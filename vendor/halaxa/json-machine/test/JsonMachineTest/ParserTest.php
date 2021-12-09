<?php

namespace JsonMachineTest;

use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Exception\PathNotFoundException;
use JsonMachine\Exception\SyntaxError;
use JsonMachine\Exception\UnexpectedEndSyntaxErrorException;
use JsonMachine\Lexer;
use JsonMachine\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataSyntax
     * @param string $jsonPointer
     * @param string $json
     * @param array $expectedResult
     */
    public function testSyntax($jsonPointer, $json, $expectedResult)
    {
        $resultWithKeys = iterator_to_array($this->createParser($json, $jsonPointer));
        $resultNoKeys = iterator_to_array($this->createParser($json, $jsonPointer), false);

        $this->assertEquals($expectedResult, $resultWithKeys);
        $this->assertEquals(array_values($expectedResult), $resultNoKeys);
    }

    public function dataSyntax()
    {
        return [
            ['', '{}', []],
            ['', '{"a": "b"}', ['a'=>'b']],
            ['', '{"a":{"b":{"c":1}}}', ['a'=>['b'=>['c'=>1]]]],
            ['', '[]', []],
            ['', '[null,true,false,"a",0,1,42.5]', [null,true,false,"a",0,1,42.5]],
            ['', '[{"c":1}]', [['c'=>1]]],
            ['', '[{"c":1},"string",{"d":2},false]', [['c'=>1],"string",['d'=>2],false]],
            ['', '[false,{"c":1},"string",{"d":2}]', [false,['c'=>1],"string",['d'=>2]]],
            ['', '[{"c":1,"d":2}]', [['c'=>1,'d'=>2]]],
            ['/', '{"":{"c":1,"d":2}}', ['c'=>1,'d'=>2]],
            ['/~0', '{"~":{"c":1,"d":2}}', ['c'=>1,'d'=>2]],
            ['/~1', '{"/":{"c":1,"d":2}}', ['c'=>1,'d'=>2]],
            ['/path', '{"path":{"c":1,"d":2}}', ['c'=>1,'d'=>2]],
            ['/path', '{"no":[null], "path":{"c":1,"d":2}}', ['c'=>1,'d'=>2]],
            ['/0', '[{"c":1,"d":2}, [null]]', ['c'=>1,'d'=>2]],
            ['/0/path', '[{"path":{"c":1,"d":2}}]', ['c'=>1,'d'=>2]],
            ['/1/path', '[[null], {"path":{"c":1,"d":2}}]', ['c'=>1,'d'=>2]],
            ['/path/0', '{"path":[{"c":1,"d":2}, [null]]}', ['c'=>1,'d'=>2]],
            ['/path/1', '{"path":[null,{"c":1,"d":2}, [null]]}', ['c'=>1,'d'=>2]],
            ['/path/to', '{"path":{"to":{"c":1,"d":2}}}', ['c'=>1,'d'=>2]],
            ['/path/after-vector', '{"path":{"array":[],"after-vector":{"c":1,"d":2}}}', ['c'=>1,'d'=>2]],
            ['/path/after-vector', '{"path":{"array":["item"],"after-vector":{"c":1,"d":2}}}', ['c'=>1,'d'=>2]],
            ['/path/after-vector', '{"path":{"object":{"item":null},"after-vector":{"c":1,"d":2}}}', ['c'=>1,'d'=>2]],
            ['/path/after-vectors', '{"path":{"array":[],"object":{},"after-vectors":{"c":1,"d":2}}}', ['c'=>1,'d'=>2]],
            ['/0/0', '[{"0":{"c":1,"d":2}}]', ['c'=>1,'d'=>2]],
            ['/1/1', '[0,{"1":{"c":1,"d":2}}]', ['c'=>1,'d'=>2]],
            'PR-19-FIX' => ['/datafeed/programs/1', file_get_contents(__DIR__.'/PR-19-FIX.json'), ['program_info'=>['id'=>'X1']]],
        ];
    }

    /**
     * @dataProvider dataThrowsOnNotFoundJsonPointer
     * @param string $json
     * @param string $jsonPointer
     */
    public function testThrowsOnNotFoundJsonPointer($json, $jsonPointer)
    {
        $parser = $this->createParser($json, $jsonPointer);
        $this->expectException(PathNotFoundException::class);
        $this->expectExceptionMessage("Path '$jsonPointer' was not found in json stream.");
        iterator_to_array($parser);
    }

    public function dataThrowsOnNotFoundJsonPointer()
    {
        return [
            "non existing pointer" => ['{}', '/not/found'],
            "empty string should not match '0'" => ['{"0":[]}', '/'],
            "empty string should not match 0" => ['[[]]', '/'],
            "0 should not match empty string" => ['{"":[]}', '/0'],
        ];
    }

    /**
     * @dataProvider dataGetJsonPointer
     * @param string $jsonPointer
     * @param array $expectedJsonPointer
     */
    public function testGetJsonPointerPath($jsonPointer, array $expectedJsonPointer)
    {
        $parser = $this->createParser('{}', $jsonPointer);
        $this->assertEquals($expectedJsonPointer, $parser->getJsonPointerPath());
    }

    public function dataGetJsonPointer()
    {
        return [
            ['/', ['']],
            ['////', ['', '', '', '']],
            ['/apple', ['apple']],
            ['/apple/pie', ['apple', 'pie']],
            ['/0/1   ', [0, '1   ']],
        ];
    }

    /**
     * @dataProvider dataThrowsOnMalformedJsonPointer
     * @param string $jsonPointer
     */
    public function testThrowsOnMalformedJsonPointer($jsonPointer)
    {
        $this->expectException(InvalidArgumentException::class);
        new Parser(new \ArrayObject(), $jsonPointer);
    }

    public function dataThrowsOnMalformedJsonPointer()
    {
        return [
            ['apple'],
            ['/apple/~'],
            ['apple/pie'],
            ['apple/pie/'],
            [' /apple/pie/'],
        ];
    }

    /**
     * @dataProvider dataSyntaxError
     * @param string $malformedJson
     */
    public function testSyntaxError($malformedJson)
    {
        $this->expectException(SyntaxError::class);

        iterator_to_array($this->createParser($malformedJson));
    }

    public function dataSyntaxError()
    {
        return [
            ['[}'],
            ['{]'],
            ['null'],
            ['true'],
            ['false'],
            ['0'],
            ['100'],
            ['"string"'],
            ['}'],
            [']'],
            [','],
            [':'],
            [''],
            ['[null null]'],
            ['["string" "string"]'],
            ['[,"string","string"]'],
            ['["string",,"string"]'],
            ['["string","string",]'],
            ['["string",1eeee1]'],
            ['{"key\u000Z": "non hex key"}']
        ];
    }

    /**
     * @dataProvider dataUnexpectedEndError
     * @param string $malformedJson
     */
    public function testUnexpectedEndError($malformedJson)
    {
        $this->expectException(UnexpectedEndSyntaxErrorException::class);

        iterator_to_array($this->createParser($malformedJson));
    }

    public function dataUnexpectedEndError()
    {
        return [
            ['['],
            ['{'],
            ['["string"'],
            ['["string",'],
            ['[{"string":"string"}'],
            ['[{"string":"string"},'],
            ['[{"string":"string"},{'],
            ['[{"string":"string"},{"str'],
            ['[{"string":"string"},{"string"'],
            ['{"string"'],
            ['{"string":'],
            ['{"string":"string"'],
            ['{"string":["string","string"]'],
            ['{"string":["string","string"'],
            ['{"string":["string","string",'],
            ['{"string":["string","string","str']
        ];
    }

    public function testScalarResult()
    {
        $result = $this->createParser('{"result":{"items": [1,2,3],"count": 3}}', '/result/count');
    }

    private function createParser($json, $jsonPointer = '')
    {
        return new Parser(new Lexer(new \ArrayIterator([$json])), $jsonPointer);
    }
}

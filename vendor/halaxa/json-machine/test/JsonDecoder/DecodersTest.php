<?php

use JsonMachine\JsonDecoder\ExtJsonDecoder;
use JsonMachine\JsonDecoder\PassThruDecoder;

class DecodersTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataPassesOptionsToJsonDecode
     */
    public function testPassesOptionsToJsonDecode($className, $methodName)
    {
        $json = '{"bigint": 123456789123456789123456789, "deep": [["deeper"]]}';

        $defaultDecoder = new $className();
        $defaultResult = $defaultDecoder->$methodName($json);
        $this->assertInternalType("object", $defaultResult->getValue());
        $this->assertNotInternalType("string", $defaultResult->getValue()->bigint);
        $this->assertSame([["deeper"]], $defaultResult->getValue()->deep);

        $assocDecoder = new $className(true);
        $assocResult = $assocDecoder->$methodName($json);
        $this->assertInternalType("array", $assocResult->getValue());

        $objDecoder = new $className(false);
        $objResult = $objDecoder->$methodName($json);
        $this->assertInternalType("object", $objResult->getValue());

        $depthDecoder = new $className(true, 1);
        $depthResult = $depthDecoder->$methodName($json);
        $this->assertFalse($depthResult->isOk());
        $this->assertSame("Maximum stack depth exceeded", $depthResult->getErrorMessage());

        $bigintDecoder = new $className(null, 1, JSON_BIGINT_AS_STRING);
        $bigintResult = $bigintDecoder->$methodName("123123123123123123123");
        $this->assertSame("123123123123123123123", $bigintResult->getValue());
    }

    public function dataPassesOptionsToJsonDecode()
    {
        return [
            [PassThruDecoder::class, 'decodeKey'],
            [ExtJsonDecoder::class, 'decodeKey'],
            [ExtJsonDecoder::class, 'decodeValue'],
        ];
    }

    public function testPassThruDecodeValue()
    {
        $passThruDecoder = new PassThruDecoder();
        $passThruResult = $passThruDecoder->decodeValue('["json"]');
        $this->assertSame('["json"]', $passThruResult->getValue());
    }
}

<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'laravel/laravel';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'anandsiddharth/laravel-paytm-wallet' => 'v1.0.16@5cf4c586e9b40cf01d8b9bc35e67f8d932318d4b',
  'apimatic/jsonmapper' => 'v2.0.2@19c9ae29bcf17fd6836776e95c3f118a63a8dee2',
  'apimatic/unirest-php' => '2.0.0@b4e399a8970c3a5c611f734282f306381f9d1eee',
  'arrilot/laravel-widgets' => '3.13.1@ae0e44ce625026ae71c6ab9259f89f13af227e37',
  'asm89/stack-cors' => 'v2.0.3@9cb795bf30988e8c96dd3c40623c48a877bc6714',
  'auth0/auth0-php' => '7.8.0@05c538b6c56a57d6d214f6a90e2b6a5d00945a51',
  'auth0/login' => '6.4.0@41eba218f0a7bd00e5ff50b0446a2e7ed9e474bd',
  'auth0/php-jwt' => '3.3.4@a0daa1a728cf85230843ebb8c1183047fe493284',
  'aws/aws-sdk-php' => '3.181.1@0829df420170e4994767860290a69487a18555f7',
  'aws/aws-sdk-php-laravel' => '3.6.0@49bc5d90b1ebfb107d0b650fd49b41b241425a36',
  'bacon/bacon-qr-code' => '1.0.3@5a91b62b9d37cee635bbf8d553f4546057250bee',
  'barryvdh/laravel-dompdf' => 'v0.8.7@30310e0a675462bf2aa9d448c8dcbf57fbcc517d',
  'bepsvpt/secure-headers' => '7.1.0@c80c5ff1357ab61495f168d560f12cc370d8b25b',
  'braintree/braintree_php' => '5.5.0@8902a072ac04c9eea2996f2683cb56259cbe46fa',
  'brick/math' => '0.9.2@dff976c2f3487d42c1db75a3b180e2b9f0e72ce0',
  'clue/stream-filter' => 'v1.5.0@aeb7d8ea49c7963d3b581378955dbf5bc49aa320',
  'composer/ca-bundle' => '1.2.9@78a0e288fdcebf92aa2318a8d3656168da6ac1a5',
  'composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6',
  'ddeboer/imap' => '1.12.1@dbed05ca67b93509345a820b2859de10c48948fb',
  'defuse/php-encryption' => 'v2.3.1@77880488b9954b7884c25555c2a0ea9e7053f9d2',
  'doctrine/cache' => '1.11.0@a9c1b59eba5a08ca2770a76eddb88922f504e8e0',
  'doctrine/dbal' => '2.13.1@c800380457948e65bbd30ba92cc17cda108bf8c9',
  'doctrine/deprecations' => 'v0.5.3@9504165960a1f83cc1480e2be1dd0a0478561314',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/inflector' => '2.0.3@9cf661f4eb38f7c881cac67c75ea9b00bf97b210',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'dompdf/dompdf' => 'v0.8.6@db91d81866c69a42dad1d2926f61515a1e3f42c5',
  'dragonmantank/cron-expression' => 'v3.1.0@7a8c6e56ab3ffcc538d05e8155bb42269abf1a0c',
  'egulias/email-validator' => '2.1.25@0dbf5d78455d4d6a41d186da50adc1122ec066f4',
  'eluceo/ical' => '0.16.1@7043337feaeacbc016844e7e52ef41bba504ad8f',
  'ezyang/htmlpurifier' => 'v4.13.0@08e27c97e4c6ed02f37c5b2b20488046c8d90d75',
  'fideloper/proxy' => '4.4.1@c073b2bd04d1c90e04dc1b787662b558dd65ade0',
  'firebase/php-jwt' => 'v5.2.1@f42c9110abe98dd6cfe9053c49bc86acc70b2d23',
  'fruitcake/laravel-cors' => 'v2.0.4@a8ccedc7ca95189ead0e407c43b530dc17791d6a',
  'gocardless/gocardless-pro' => '4.6.2@4db4690f8eeced35a56f0bd11e2525a187627b53',
  'graham-campbell/guzzle-factory' => 'v5.0.0@5f6eae0dba2f2a02d72d42f11f3ff9f9f61e1cc8',
  'graham-campbell/result-type' => 'v1.0.1@7e279d2cd5d7fbb156ce46daada972355cea27bb',
  'guzzlehttp/guzzle' => '7.3.0@7008573787b430c1c1f650e3722d9bba59967628',
  'guzzlehttp/promises' => '1.4.1@8e7d04f1f6450fef59366c399cfad4b9383aa30d',
  'guzzlehttp/psr7' => '1.8.2@dc960a912984efb74d0a90222870c72c87f10c91',
  'halaxa/json-machine' => '0.4.1@abba99cd7657673dfdf2ecf40553c78f3bfdffd8',
  'hautelook/phpass' => '1.1.0@b2daca28508000d1dd126e93ec472d771626a774',
  'http-interop/http-factory-guzzle' => '1.0.0@34861658efb9899a6618cef03de46e2a52c80fc0',
  'intervention/image' => '2.5.1@abbf18d5ab8367f96b3205ca3c89fb2fa598c69e',
  'jean85/pretty-package-versions' => '2.0.3@b2c4ec2033a0196317a467cb197c7c843b794ddf',
  'kwn/number-to-words' => '1.12.1@7461b531a971eb6b75a687eb28787b79dad09eb1',
  'laminas/laminas-diactoros' => '2.5.1@53df7b7cd66e0905e6133970a4b90392a7a08075',
  'laminas/laminas-zendframework-bridge' => '1.2.0@6cccbddfcfc742eb02158d6137ca5687d92cee32',
  'laravel-notification-channels/messagebird' => 'v3.0.0@3a2681920e6684c99f8e37dcad8cdffa724fff83',
  'laravel-notification-channels/telegram' => '0.5.1@2cedb10b78219cc91a285eaa5a3de0db405cc207',
  'laravel-notification-channels/twilio' => '3.1.2@509c76853124418ca21f3257c0c832cc5018cfd2',
  'laravel/cashier' => 'v12.13.1@532089a487dd09c6fa5adaf9c0088715a7623e48',
  'laravel/framework' => 'v8.41.0@05417155d886df8710e55c84e12622b52d83c47c',
  'laravel/helpers' => 'v1.4.1@febb10d8daaf86123825de2cb87f789a3371f0ac',
  'laravel/nexmo-notification-channel' => 'v2.5.1@178c9f0eb3a18d4b5682471bffca104a15d817a7',
  'laravel/passport' => 'v10.0.1@4e53f1b237a9e51ac10f0b30c6ebedd68f6848ab',
  'laravel/slack-notification-channel' => 'v2.3.1@f428e76b8d0a0a2ff413ab225eeb829b9a8ffc20',
  'laravel/socialite' => 'v5.2.3@1960802068f81e44b2ae9793932181cf1cb91b5c',
  'laravel/tinker' => 'v2.6.1@04ad32c1a3328081097a181875733fa51f402083',
  'laravel/ui' => 'v3.2.1@e2478cd0342a92ec1c8c77422553bda8ee004fd0',
  'laravelcollective/html' => 'v6.2.1@ae15b9c4bf918ec3a78f092b8555551dd693fde3',
  'lcobucci/jwt' => '3.3.3@c1123697f6a2ec29162b82f170dd4a491f524773',
  'league/commonmark' => '1.6.2@7d70d2f19c84bcc16275ea47edabee24747352eb',
  'league/event' => '2.2.0@d2cc124cf9a3fab2bb4ff963307f60361ce4d119',
  'league/flysystem' => '1.1.3@9be3b16c877d477357c015cec057548cf9b2a14a',
  'league/flysystem-aws-s3-v3' => '1.0.29@4e25cc0582a36a786c31115e419c6e40498f6972',
  'league/html-to-markdown' => '4.10.0@0868ae7a552e809e5cd8f93ba022071640408e88',
  'league/mime-type-detection' => '1.7.0@3b9dff8aaf7323590c1d2e443db701eb1f9aa0d3',
  'league/oauth1-client' => 'v1.9.0@1e7e6be2dc543bf466236fb171e5b20e1b06aee6',
  'league/oauth2-server' => '8.1.1@09f22e8121fa1832962dba18213b80d4267ef8a3',
  'livewire/livewire' => 'v2.4.4@33101c83b75728651b9e668a4559f97def7c9138',
  'lusitanian/oauth' => 'v0.8.11@fc11a53db4b66da555a6a11fce294f574a8374f9',
  'maatwebsite/excel' => '3.1.30@aa5d2e4d25c5c8218ea0a15103da95f5f8728953',
  'maennchen/zipstream-php' => '2.1.0@c4c5803cc1f93df3d2448478ef79394a5981cc58',
  'markbaker/complex' => '2.0.0@9999f1432fae467bc93c53f357105b4c31bb994c',
  'markbaker/matrix' => '2.1.2@361c0f545c3172ee26c3d596a0aa03f0cef65e6a',
  'mollie/laravel-mollie' => 'v2.14.0@e5b2acc3672c64bb790a3e67dfe01cf3bacbfa0b',
  'mollie/mollie-api-php' => 'v2.31.1@c1a500d251255e29919c6250d5c741ae4fe4e178',
  'moneyphp/money' => 'v3.3.1@122664c2621a95180a13c1ac81fea1d2ef20781e',
  'monolog/monolog' => '2.2.0@1cb1cde8e8dd0f70cc0fe51354a59acad9302084',
  'mtdowling/jmespath.php' => '2.6.0@42dae2cbd13154083ca6d70099692fef8ca84bfb',
  'myclabs/php-enum' => '1.8.0@46cf3d8498b095bd33727b13fd5707263af99421',
  'nesbot/carbon' => '2.48.0@d3c447f21072766cddec3522f9468a5849a76147',
  'nestednet/gocardless-laravel' => 'v0.2.1@748212417881eadd8722c7c519895e52569aae0b',
  'nexmo/laravel' => '2.4.1@029bdc19fc58cd6ef0aa75c7041d82b9d9dc61bd',
  'nikic/php-parser' => 'v4.10.5@4432ba399e47c66624bc73c8c0f811e5c109576f',
  'nwidart/laravel-modules' => '8.2.0@6ade5ec19e81a0e4807834886a2c47509d069cb7',
  'nyholm/psr7' => '1.4.0@23ae1f00fbc6a886cbe3062ca682391b9cc7c37b',
  'opis/closure' => '3.6.2@06e2ebd25f2869e54a306dda991f7db58066f7f6',
  'paragonie/constant_time_encoding' => 'v2.4.0@f34c2b11eb9d2c9318e13540a1dbc2a3afbd939c',
  'paragonie/random_compat' => 'v9.99.100@996434e5492cb4c3edcb9168db6fbb1359ef965a',
  'paragonie/sodium_compat' => 'v1.16.0@928e0565c9fe4f60b8f09119656c1aa418fc84ab',
  'phenx/php-font-lib' => '0.5.2@ca6ad461f032145fff5971b5985e5af9e7fa88d8',
  'phenx/php-svg-lib' => 'v0.3.3@5fa61b65e612ce1ae15f69b3d223cb14ecc60e32',
  'php-http/client-common' => '2.3.0@e37e46c610c87519753135fb893111798c69076a',
  'php-http/discovery' => '1.13.0@788f72d64c43dc361e7fcc7464c3d947c64984a7',
  'php-http/httplug' => '2.2.0@191a0a1b41ed026b717421931f8d3bd2514ffbf9',
  'php-http/message' => '1.11.0@fb0dbce7355cad4f4f6a225f537c34d013571f29',
  'php-http/message-factory' => 'v1.0.2@a478cb11f66a6ac48d8954216cfed9aa06a501a1',
  'php-http/promise' => '1.1.0@4c4c1f9b7289a2ec57cde7f1e9762a5789506f88',
  'phpoffice/phpspreadsheet' => '1.16.0@76d4323b85129d0c368149c831a07a3e258b2b50',
  'phpoption/phpoption' => '1.7.5@994ecccd8f3283ecf5ac33254543eb0ac946d525',
  'phpseclib/phpseclib' => '2.0.31@233a920cb38636a43b18d428f9a8db1f0a1a08f4',
  'pragmarx/google2fa' => '8.0.0@26c4c5cf30a2844ba121760fd7301f8ad240100b',
  'pragmarx/google2fa-laravel' => 'v1.4.1@f9014fd7ea36a1f7fffa233109cf59b209469647',
  'pragmarx/google2fa-qrcode' => 'v1.0.3@fd5ff0531a48b193a659309cc5fb882c14dbd03f',
  'predis/predis' => 'v1.1.7@b240daa106d4e02f0c5b7079b41e31ddf66fddf8',
  'psr/container' => '1.1.1@8622567409010282b7aeebe4bb841fe98b58dcaf',
  'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0',
  'psr/http-client' => '1.0.1@2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.4@d49695b909c3b7628b6289db5479a1c204601f11',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'psy/psysh' => 'v0.10.8@e4573f47750dd6c92dca5aee543fa77513cbd8d3',
  'pusher/pusher-php-server' => 'v4.1.5@251f22602320c1b1aff84798fe74f3f7ee0504a9',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'ramsey/collection' => '1.1.3@28a5c4ab2f5111db6a60b2b4ec84057e0f43b9c1',
  'ramsey/uuid' => '4.1.1@cd4032040a750077205918c86049aa0f43d22947',
  'razorpay/razorpay' => '2.7.0@e28454acdc110b544fc80bec9518b9b86b275a2c',
  'renatomarinho/laravel-page-speed' => '1.9.0@7639014cde1bbb8dbe3e22be6ff92bee00671625',
  'rmccue/requests' => 'v1.8.0@afbe4790e4def03581c4a0963a1e8aa01f6030f1',
  'sabberworm/php-css-parser' => '8.3.1@d217848e1396ef962fb1997cf3e2421acba7f796',
  'sentry/sdk' => '3.1.0@f03133b067fdf03fed09ff03daf3f1d68f5f3673',
  'sentry/sentry' => '3.2.2@02237728bdc5b82b0a14c37417644e3f3606db9b',
  'sentry/sentry-laravel' => '2.5.3@23ea0d80cb2eb7d0d056879726f7800549fc7c01',
  'setasign/tfpdf' => 'v1.32@a879b83485c263605cbf98ab2e8fdd4d37ca2707',
  'spatie/db-dumper' => '2.21.1@05e5955fb882008a8947c5a45146d86cfafa10d1',
  'spatie/dropbox-api' => '1.17.1@4d1acfcc83b61d460067b3ae2d5d3d2da10439f5',
  'spatie/flysystem-dropbox' => '1.2.3@8b6b072f217343b875316ca6a4203dd59f04207a',
  'spatie/laravel-backup' => '6.16.0@6b2229a07d92c2bb146ad9c5223fc32e9d74830c',
  'spatie/laravel-permission' => '3.18.0@1c51a5fa12131565fe3860705163e53d7a26258a',
  'spatie/laravel-translation-loader' => '2.7.0@16c9ac39a4dbf4c978ab48921e27362cbbb429b0',
  'spatie/temporary-directory' => '1.3.0@f517729b3793bca58f847c5fd383ec16f03ffec6',
  'square/square' => '6.5.0.20201028@8fd4046bab731a5d21d43ae51101a30f12072bc8',
  'str/str' => '1.1.3@2e1b2d27a11b698564ac3097a7b011ff6d78c5c8',
  'stripe/stripe-php' => 'v7.78.0@6ec33fa8e9de2322be93d28dfd685661c67ca549',
  'swiftmailer/swiftmailer' => 'v6.2.7@15f7faf8508e04471f666633addacf54c0ab5933',
  'symfony/console' => 'v5.2.8@864568fdc0208b3eba3638b6000b69d2386e6768',
  'symfony/css-selector' => 'v5.2.7@59a684f5ac454f066ecbe6daecce6719aed283fb',
  'symfony/deprecation-contracts' => 'v2.4.0@5f38c8804a9e97d23e0c8d63341088cd8a22d627',
  'symfony/dom-crawler' => 'v5.2.4@400e265163f65aceee7e904ef532e15228de674b',
  'symfony/error-handler' => 'v5.2.8@1416bc16317a8188aabde251afef7618bf4687ac',
  'symfony/event-dispatcher' => 'v5.2.4@d08d6ec121a425897951900ab692b612a61d6240',
  'symfony/event-dispatcher-contracts' => 'v2.4.0@69fee1ad2332a7cbab3aca13591953da9cdb7a11',
  'symfony/finder' => 'v5.2.8@eccb8be70d7a6a2230d05f6ecede40f3fdd9e252',
  'symfony/http-client' => 'v5.2.8@a2baf9c3c5b25e04740cece0e429f0a0013002f2',
  'symfony/http-client-contracts' => 'v2.4.0@7e82f6084d7cae521a75ef2cb5c9457bbda785f4',
  'symfony/http-foundation' => 'v5.2.8@e8fbbab7c4a71592985019477532629cb2e142dc',
  'symfony/http-kernel' => 'v5.2.8@c3cb71ee7e2d3eae5fe1001f81780d6a49b37937',
  'symfony/mime' => 'v5.2.7@7af452bf51c46f18da00feb32e1ad36db9426515',
  'symfony/options-resolver' => 'v5.2.4@5d0f633f9bbfcf7ec642a2b5037268e61b0a62ce',
  'symfony/polyfill-ctype' => 'v1.22.1@c6c942b1ac76c82448322025e084cadc56048b4e',
  'symfony/polyfill-iconv' => 'v1.22.1@06fb361659649bcfd6a208a0f1fcaf4e827ad342',
  'symfony/polyfill-intl-grapheme' => 'v1.22.1@5601e09b69f26c1828b13b6bb87cb07cddba3170',
  'symfony/polyfill-intl-icu' => 'v1.22.1@af1842919c7e7364aaaa2798b29839e3ba168588',
  'symfony/polyfill-intl-idn' => 'v1.22.1@2d63434d922daf7da8dd863e7907e67ee3031483',
  'symfony/polyfill-intl-normalizer' => 'v1.22.1@43a0283138253ed1d48d352ab6d0bdb3f809f248',
  'symfony/polyfill-mbstring' => 'v1.22.1@5232de97ee3b75b0360528dae24e73db49566ab1',
  'symfony/polyfill-php72' => 'v1.22.1@cc6e6f9b39fe8075b3dabfbaf5b5f645ae1340c9',
  'symfony/polyfill-php73' => 'v1.22.1@a678b42e92f86eca04b7fa4c0f6f19d097fb69e2',
  'symfony/polyfill-php80' => 'v1.22.1@dc3063ba22c2a1fd2f45ed856374d79114998f91',
  'symfony/polyfill-uuid' => 'v1.22.1@9773608c15d3fe6ba2b6456a124777a7b8ffee2a',
  'symfony/process' => 'v5.2.7@98cb8eeb72e55d4196dd1e36f1f16e7b3a9a088e',
  'symfony/psr-http-message-bridge' => 'v2.1.0@81db2d4ae86e9f0049828d9343a72b9523884e5d',
  'symfony/routing' => 'v5.2.7@3f0cab2e95b5e92226f34c2c1aa969d3fc41f48c',
  'symfony/service-contracts' => 'v2.4.0@f040a30e04b57fbcc9c6cbcf4dbaa96bd318b9bb',
  'symfony/string' => 'v5.2.8@01b35eb64cac8467c3f94cd0ce2d0d376bb7d1db',
  'symfony/translation' => 'v5.2.8@445caa74a5986f1cc9dd91a2975ef68fa7cb2068',
  'symfony/translation-contracts' => 'v2.4.0@95c812666f3e91db75385749fe219c5e494c7f95',
  'symfony/var-dumper' => 'v5.2.8@d693200a73fae179d27f8f1b16b4faf3e8569eba',
  'tijsverkoyen/css-to-inline-styles' => '2.2.3@b43b05cf43c1b6d849478965062b6ef73e223bb5',
  'twilio/sdk' => '6.23.0@4e69cc175512db9ef07e87e92c124aefa4d01360',
  'vlucas/phpdotenv' => 'v5.3.0@b3eac5c7ac896e52deab4a99068e3f4ab12d9e56',
  'voku/portable-ascii' => '1.5.6@80953678b19901e5165c56752d087fc11526017c',
  'vonage/client' => '2.4.0@29f23e317d658ec1c3e55cf778992353492741d7',
  'vonage/client-core' => 'v2.6.0@0c293b4649ba7e6ab212b74db9933b81acc399eb',
  'vonage/nexmo-bridge' => '0.1.0@62653b1165f4401580ca8d2b859f59c968de3711',
  'webmozart/assert' => '1.10.0@6964c76c7804814a842473e0c8fd15bab0f18e25',
  'wepay/php-sdk' => '0.3.1@2a89ceb2954d117d082f869d3bfcb7864e6c2a7d',
  'wmandai/aws-pinpoint-laravel-notification-channel' => 'v0.1.3@e66fb2b18b289f3f4b1dc1c970495e2c96082722',
  'wmandai/oauth-5-laravel' => 'v1.0.7.1@015a651222a1e5f00335c4848d69d97d14853fe3',
  'wmandai/pdf-invoice' => '1.4.2@0a51a81d1987e34352d3558e8ae0b1101e67884a',
  'wmandai/repositories' => '1.0.2@f88c1eba5d3a4155797b1ce8345d4a894a9575ea',
  'yajra/laravel-datatables-oracle' => 'v9.18.0@b00f25b1941879b34e05f270835235a32b46567c',
  'barryvdh/laravel-debugbar' => 'v3.5.7@88fd9cfa144b06b2549e9d487fdaec68265e791e',
  'beyondcode/laravel-self-diagnosis' => '1.5.0@b9f235747a3b06cee3cffe152deabc37dc93cca4',
  'composer/semver' => '1.7.2@647490bbcaf7fc4891c58f47b825eb99d19c377a',
  'deployer/deployer' => 'v6.8.0@4e243a64ed61e779fbb31c5a74e258a8e52fdaff',
  'deployer/phar-update' => 'v2.2.0@9ad07422f2cd43a1382ee8e134bdcd3a374848e3',
  'doctrine/instantiator' => '1.4.0@d56bf6102915de5702778fe20f2de3b2fe570b5b',
  'facade/flare-client-php' => '1.8.0@69742118c037f34ee1ef86dc605be4a105d9e984',
  'facade/ignition' => '2.9.0@e7db3b601ce742568b92648818ef903904d20164',
  'facade/ignition-contracts' => '1.0.2@3c921a1cdba35b68a7f0ccffc6dffc1995b18267',
  'fakerphp/faker' => 'v1.14.1@ed22aee8d17c7b396f74a58b1e7fefa4f90d5ef1',
  'filp/whoops' => '2.12.1@c13c0be93cff50f88bbd70827d993026821914dd',
  'geerlingguy/ping' => '1.2.1@e0206326e23c99e3e8820e24705f8ca517adff93',
  'hamcrest/hamcrest-php' => 'v2.0.1@8c3d0a3f6af734494ad8f6fbbee0ba92422859f3',
  'maximebf/debugbar' => 'v1.16.5@6d51ee9e94cff14412783785e79a4e7ef97b9d62',
  'mockery/mockery' => '1.4.3@d1339f64479af1bee0e82a0413813fe5345a54ea',
  'myclabs/deep-copy' => '1.10.2@776f831124e9c62e1a2c601ecc52e776d8bb7220',
  'nunomaduro/collision' => 'v5.4.0@41b7e9999133d5082700d31a1d0977161df8322a',
  'phar-io/manifest' => '2.0.1@85265efd3af7ba3ca4b2a2c34dbfc5788dd29133',
  'phar-io/version' => '3.1.0@bae7c545bef187884426f042434e561ab1ddb182',
  'phpdocumentor/reflection-common' => '2.2.0@1d01c49d4ed62f25aa84a747ad35d5a16924662b',
  'phpdocumentor/reflection-docblock' => '5.2.2@069a785b2141f5bcf49f3e353548dc1cce6df556',
  'phpdocumentor/type-resolver' => '1.4.0@6a467b8989322d92aa1c8bf2bebcc6e5c2ba55c0',
  'phpspec/prophecy' => '1.13.0@be1996ed8adc35c3fd795488a653f4b518be70ea',
  'phpunit/php-code-coverage' => '9.2.6@f6293e1b30a2354e8428e004689671b83871edde',
  'phpunit/php-file-iterator' => '3.0.5@aa4be8575f26070b100fccb67faabb28f21f66f8',
  'phpunit/php-invoker' => '3.1.1@5a10147d0aaf65b58940a0b72f71c9ac0423cc67',
  'phpunit/php-text-template' => '2.0.4@5da5f67fc95621df9ff4c4e5a84d6a8a2acf7c28',
  'phpunit/php-timer' => '5.0.3@5a63ce20ed1b5bf577850e2c4e87f4aa902afbd2',
  'phpunit/phpunit' => '9.5.4@c73c6737305e779771147af66c96ca6a7ed8a741',
  'pimple/pimple' => 'v3.4.0@86406047271859ffc13424a048541f4531f53601',
  'sebastian/cli-parser' => '1.0.1@442e7c7e687e42adc03470c7b668bc4b2402c0b2',
  'sebastian/code-unit' => '1.0.8@1fc9f64c0927627ef78ba436c9b17d967e68e120',
  'sebastian/code-unit-reverse-lookup' => '2.0.3@ac91f01ccec49fb77bdc6fd1e548bc70f7faa3e5',
  'sebastian/comparator' => '4.0.6@55f4261989e546dc112258c7a75935a81a7ce382',
  'sebastian/complexity' => '2.0.2@739b35e53379900cc9ac327b2147867b8b6efd88',
  'sebastian/diff' => '4.0.4@3461e3fccc7cfdfc2720be910d3bd73c69be590d',
  'sebastian/environment' => '5.1.3@388b6ced16caa751030f6a69e588299fa09200ac',
  'sebastian/exporter' => '4.0.3@d89cc98761b8cb5a1a235a6b703ae50d34080e65',
  'sebastian/global-state' => '5.0.2@a90ccbddffa067b51f574dea6eb25d5680839455',
  'sebastian/lines-of-code' => '1.0.3@c1c2e997aa3146983ed888ad08b15470a2e22ecc',
  'sebastian/object-enumerator' => '4.0.4@5c9eeac41b290a3712d88851518825ad78f45c71',
  'sebastian/object-reflector' => '2.0.4@b4f479ebdbf63ac605d183ece17d8d7fe49c15c7',
  'sebastian/recursion-context' => '4.0.4@cd9d8cf3c5804de4341c283ed787f099f5506172',
  'sebastian/resource-operations' => '3.0.3@0f4443cb3a1d92ce809899753bc0d5d5a8dd19a8',
  'sebastian/type' => '2.3.1@81cd61ab7bbf2de744aba0ea61fae32f721df3d2',
  'sebastian/version' => '3.0.2@c6c1022351a901512170118436c764e473f6de8c',
  'squizlabs/php_codesniffer' => '3.6.0@ffced0d2c8fa8e6cdc4d695a743271fab6c38625',
  'symfony/debug' => 'v4.4.22@45b2136377cca5f10af858968d6079a482bca473',
  'symfony/yaml' => 'v5.2.7@76546cbeddd0a9540b4e4e57eddeec3e9bb444a5',
  'theseer/tokenizer' => '1.2.0@75a63c33a8577608444246075ea0af0d052e452a',
  'laravel/laravel' => 'dev-master@00d4daffef565801a0048b9ce0afcbeea3e5c105',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!class_exists(InstalledVersions::class, false) || !InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (class_exists(InstalledVersions::class, false) && InstalledVersions::getRawData()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}

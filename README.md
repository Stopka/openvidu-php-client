# OpenVidu php client
Php port of [openvidu-java-client](https://github.com/OpenVidu/openvidu/tree/master/openvidu-java-client), library simplifing openvidu server connection using it's exposed REST API.

## Install
Installation via Composer.

```sh
composer require stopka/openvidu-php-client "dev-master@dev" 
```

## Usage examples
Usage should be similar to the original [java client API](https://openvidu.io/docs/reference-docs/openvidu-java-client/).

### Create session

```php
$openvidu = new OpenVidu(OPENVIDU_URL, OPENVIDU_SECRET);
$sessionProperties = new SessionPropertiesBuilder();
$session = $openVidu->createSession($sessionProperties->build());
```

### Generate token

```php
$tokenOptions = new TokenOptions\TokenOptionsBuilder();
$tokenOptions->setRole(new OpenViduRoleEnum(OpenViduRoleEnum::PUBLISHER))
            ->setData(json_encode($tokenData));
$token = $session->generateToken($tokenOptions->build());
```

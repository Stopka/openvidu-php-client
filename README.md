# OpenVidu php client
Php port of [openvidu-java-client](https://github.com/OpenVidu/openvidu/tree/master/openvidu-java-client), library simplifing openvidu server connection using it's exposed REST API.

##Install
Installation via Composer.

``
composer require stopka/openvidu-php-client "dev-master@dev" 
``

## Usage examples
Usage should be similar to the original [java client API](https://openvidu.io/docs/reference-docs/openvidu-java-client/).

### Create session

``
$openvidu = new OpenVidu(OPENVIDU_URL, OPENVIDU_SECRET);
$session = $openVidu->createSession();
``

### Generate token

``
$tokenOptions = new TokenOptions\TokenOptionsBuilder();
$tokenOptions->setRole(OpenViduRole::PUBLISHER)
            ->setData(json_encode($tokenData));
$token = $session->generateToken($tokenOptions->build());
``
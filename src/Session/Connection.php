<?php


namespace Stopka\OpenviduPhpClient\Session;


use DateTime;
use Stopka\OpenviduPhpClient\EnumException;
use Stopka\OpenviduPhpClient\OpenViduRoleEnum;

class Connection
{
    /** @var string */
    private $connectionId;

    /** @var DateTime */
    private $createdAt;

    /** @var OpenViduRoleEnum */
    private $role;

    /** @var string */
    private $token;

    /** @var string */
    private $location;

    /** @var string */
    private $platform;

    /** @var string */
    private $serverData;

    /** @var string */
    private $clientData;

    /** @var Publisher[] */
    protected $publishers;

    /** @var string[] */
    protected $subscribers;

    /**
     * Connection constructor.
     * @param string $connectionId
     * @param DateTime $createdAt
     * @param OpenViduRoleEnum $role
     * @param string $token
     * @param string $location
     * @param string $platform
     * @param string $serverData
     * @param string $clientData
     * @param Publisher[] $publishers
     * @param string[] $subscribers
     */
    public function __construct(
        string $connectionId,
        DateTime $createdAt,
        OpenViduRoleEnum $role,
        string $token,
        string $location,
        string $platform,
        string $serverData,
        string $clientData,
        array $publishers,
        array $subscribers
    ) {
        $this->connectionId = $connectionId;
        $this->createdAt = $createdAt;
        $this->role = $role;
        $this->token = $token;
        $this->location = $location;
        $this->platform = $platform;
        $this->serverData = $serverData;
        $this->clientData = $clientData;
        $this->publishers = $publishers;
        $this->subscribers = $subscribers;
    }

    /**
     * @return string
     */
    public function getConnectionId(): string
    {
        return $this->connectionId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return OpenViduRoleEnum
     */
    public function getRole(): OpenViduRoleEnum
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @return string
     */
    public function getServerData(): string
    {
        return $this->serverData;
    }

    /**
     * @return string
     */
    public function getClientData(): string
    {
        return $this->clientData;
    }

    /**
     * @return Publisher[]
     */
    public function getPublishers(): array
    {
        return clone $this->publishers;
    }

    /**
     * @return string[]
     */
    public function getSubscribers(): array
    {
        return clone $this->subscribers;
    }

    public function setSubscribers(array $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    /**
     * @param array $data
     * @return Connection
     * @throws EnumException
     */
    public static function createFromDataArray(array $data): Connection
    {
        $publishers = [];
        foreach ($data['publishers'] as $arrayPublisher) {
            $publisher = Publisher::createFromDataArray($arrayPublisher);
            $publishers[$publisher->getStreamId()] = $publisher;
        }
        $subscribers = [];
        foreach ($data['subscribers'] as $arraySubscriber) {
            $subscribers = $arraySubscriber['streamId'];
        }
        return new Connection(
            $data['connectionId'],
            (new DateTime())->setTimestamp($data['createdAt']),
            new OpenViduRoleEnum($data['role']),
            $data['token'],
            $data['location'],
            $data['platform'],
            $data['serverData'],
            $data['clientData'],
            $publishers,
            $subscribers
        );
    }

    public function getDataArray(): array
    {
        $publishers = [];
        foreach ($this->publishers as $publisher) {
            $publishers[] = $publisher->getDataArray();
        }
        return [
            'connectionId' => $this->connectionId,
            'role' => (string)$this->role,
            'token' => $this->token,
            'clientData' => $this->clientData,
            'serverData' => $this->serverData,
            'publishers' => $publishers,
            'subscribers' => clone $this->subscribers
        ];
    }
}

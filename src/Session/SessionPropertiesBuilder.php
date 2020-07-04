<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Session;

use Stopka\OpenviduPhpClient\MediaModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingLayoutEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingModeEnum;
use Stopka\OpenviduPhpClient\Recording\RecordingOutputModeEnum;

class SessionPropertiesBuilder
{
    /**
     * @var MediaModeEnum
     */
    private MediaModeEnum $mediaMode;

    /**
     * @var RecordingModeEnum
     */
    private RecordingModeEnum $recordingMode;

    /**
     * @var RecordingOutputModeEnum
     */
    private RecordingOutputModeEnum $defaultOutputMode;

    /**
     * @var RecordingLayoutEnum
     */
    private RecordingLayoutEnum $defaultRecordingLayout;

    /**
     * @var string|null
     */
    private ?string $defaultCustomLayout = null;

    /**
     * @var string|null
     */
    private ?string $customSessionId = null;

    public function __construct()
    {
        $this->mediaMode = new MediaModeEnum(MediaModeEnum::ROUTED);
        $this->recordingMode = new RecordingModeEnum(RecordingModeEnum::MANUAL);
        $this->defaultOutputMode = new RecordingOutputModeEnum(RecordingOutputModeEnum::COMPOSED);
        $this->defaultRecordingLayout = new RecordingLayoutEnum(RecordingLayoutEnum::BEST_FIT);
    }


    /**
     * Returns the {@link io.openvidu.java.client.SessionProperties} object properly
     * configured
     */
    public function build(): SessionProperties
    {
        return new SessionProperties(
            $this->mediaMode,
            $this->recordingMode,
            $this->defaultOutputMode,
            $this->defaultRecordingLayout,
            $this->defaultCustomLayout,
            $this->customSessionId
        );
    }


    /**
     * Call this method to set how the media streams will be sent and received by
     * your clients: routed through OpenVidu Media Server
     * (<code>MediaModeEnum.ROUTED</code>) or attempting direct p2p connections
     * (<code>MediaModeEnum.RELAYED</code>, <i>not available yet</i>)
     *
     * Default value is <code>MediaModeEnum.ROUTED</code>
     *
     * @param  MediaModeEnum $mediaMode
     * @return static
     */
    public function setMediaMode(MediaModeEnum $mediaMode): self
    {
        $this->mediaMode = $mediaMode;

        return $this;
    }

    /**
     * Call this method to set whether the Session will be automatically recorded
     * (<code>RecordingModeEnum.ALWAYS</code>) or not
     * (<code>RecordingModeEnum.MANUAL</code>)
     *
     * Default value is <code>RecordingModeEnum.MANUAL</code>
     *
     * @param  RecordingModeEnum $recordingMode
     * @return static
     */
    public function setRecordingMode(RecordingModeEnum $recordingMode): self
    {
        $this->recordingMode = $recordingMode;

        return $this;
    }

    /**
     * Call this method to set the the default value used to initialize property
     * {@link io.openvidu.java.client.RecordingProperties#outputMode()} of every
     * recording of this session. You can easily override this value later when
     * starting a {@link io.openvidu.java.client.Recording} by calling
     * {@link io.openvidu.java.client.RecordingProperties.Builder#outputMode(Recording.OutputMode)}
     * with any other value.<br>
     *
     * @param  RecordingOutputModeEnum $defaultOutputMode
     * @return static
     */
    public function setDefaultOutputMode(RecordingOutputModeEnum $defaultOutputMode): self
    {
        $this->defaultOutputMode = $defaultOutputMode;

        return $this;
    }

    /**
     * Call this method to set the the default value used to initialize property
     * {@link io.openvidu.java.client.RecordingProperties#recordingLayout()} of
     * every recording of this session. You can easily override this value later
     * when initializing a {@link io.openvidu.java.client.Recording} by calling
     * {@link io.openvidu.java.client.RecordingProperties.Builder#recordingLayout(RecordingLayoutEnum)}
     * with any other value
     *
     * Default value is <code>RecordingLayoutEnum.BEST_FIT</code>
     *
     * @param  RecordingLayoutEnum $layout
     * @return static
     */
    public function setDefaultRecordingLayout(RecordingLayoutEnum $layout): self
    {
        $this->defaultRecordingLayout = $layout;

        return $this;
    }

    /**
     * Call this method to set the default value used to initialize property
     * {@link io.openvidu.java.client.RecordingProperties#customLayout()} of every
     * recording of this session. You can easily override this value later when
     * initializing a {@link io.openvidu.java.client.Recording} by calling
     * {@link io.openvidu.java.client.RecordingProperties.Builder#customLayout(String)}
     * with any other value
     *
     * @param  string $path
     * @return static
     */
    public function setDefaultCustomLayout(?string $path): self
    {
        $this->defaultCustomLayout = $path;

        return $this;
    }

    /**
     * Call this method to fix the sessionId that will be assigned to the session.
     * You can take advantage of this property to facilitate the mapping between
     * OpenVidu Server 'session' entities and your own 'session' entities. If this
     * parameter is undefined or an empty string, OpenVidu Server will generate a
     * random sessionId for you.
     *
     * @param  string $customSessionId
     * @return static
     */
    public function setCustomSessionId(?string $customSessionId): self
    {
        $this->customSessionId = $customSessionId;

        return $this;
    }
}

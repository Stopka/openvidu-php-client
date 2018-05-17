<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 12:51
 */

namespace Stopka\OpenviduPhpClient;


class SessionPropertiesBuilder {
    /** @var string */
    private $mediaMode = MediaMode::ROUTED;

    /** @var string */
    private $recordingMode = RecordingMode::MANUAL;

    /** @var string */
    private $defaultRecordingLayout = RecordingLayout::BEST_FIT;

    /** @var string */
    private $defaultCustomLayout = "";

    /** @var string */
    private $customSessionId = "";

    /**
     * Returns the {@link io.openvidu.java.client.SessionProperties} object properly
     * configured
     */
    public function build(): SessionProperties {
        return new SessionProperties(
            $this->mediaMode,
            $this->recordingMode,
            $this->defaultRecordingLayout,
            $this->defaultCustomLayout,
            $this->customSessionId
        );
    }


    /**
     * Call this method to set how the media streams will be sent and received by
     * your clients: routed through OpenVidu Media Server
     * (<code>MediaMode.ROUTED</code>) or attempting direct p2p connections
     * (<code>MediaMode.RELAYED</code>, <i>not available yet</i>)
     *
     * Default value is <code>MediaMode.ROUTED</code>
     */
    public function mediaMode(string $mediaMode): self {
        $this->mediaMode = $mediaMode;
        return $this;
    }

    /**
     * Call this method to set whether the Session will be automatically recorded
     * (<code>RecordingMode.ALWAYS</code>) or not
     * (<code>RecordingMode.MANUAL</code>)
     *
     * Default value is <code>RecordingMode.MANUAL</code>
     */
    public function recordingMode(string $recordingMode): self {
        $this->recordingMode = $recordingMode;
        return $this;
    }

    /**
     * Call this method to set the the default value used to initialize property
     * {@link io.openvidu.java.client.RecordingProperties#recordingLayout()} of
     * every recording of this session. You can easily override this value later
     * when initializing a {@link io.openvidu.java.client.Recording} by calling
     * {@link io.openvidu.java.client.RecordingProperties.Builder#recordingLayout(RecordingLayout)}
     * with any other value
     *
     * Default value is <code>RecordingLayout.BEST_FIT</code>
     */
    public function defaultRecordingLayout(string $layout): self {
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
     */
    public function defaultCustomLayout(string $path): self {
        $this->defaultCustomLayout = $path;
        return $this;
    }

    /**
     * Call this method to fix the sessionId that will be assigned to the session.
     * You can take advantage of this property to facilitate the mapping between
     * OpenVidu Server 'session' entities and your own 'session' entities. If this
     * parameter is undefined or an empty string, OpenVidu Server will generate a
     * random sessionId for you.
     */
    public function customSessionId(string $customSessionId): self {
        $this->customSessionId = $customSessionId;
        return $this;
    }
}
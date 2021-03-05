<?php
namespace App\Services;

class WhatsappMessage
{
    /** @var string */
    protected $to;
    /** @var string */
    protected $message;
    /** @var string|int */
    protected $from;
    protected $custom_data;
    /**
     * @param string $to
     *
     * @return static
     */
    public static function create($to = '')
    {
        return new static($to);
    }
    /**
     * @param string $to
     */
    public function __construct($to = '')
    {
        $this->to = $to;
    }
    /**
     * Set the card name.
     *
     * @param $to
     *
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }
    /**
     * Set the card description.
     *
     * @param $message
     *
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;
        return $this;
    }
    /**
     * Set the card position.
     *
     * @param string|int $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Set the chat id
     *
     * @param string|int $data
     *
     * @return $this
     */
    public function custom($data)
    {
        $this->custom_data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'apikey' => get_option('whatsapp_key'),
            'number'      => $this->to,
            'text' => $this->message,
            'custom_data' => $this->custom_data,
        ];
    }
}

<?php


namespace App\Services\Helpers;


class TrashVaccineLocation
{

    /**
     * TrashVaccineLocation constructor.
     *
     * @param string|null $id
     * @param string|null $subtitle
     * @param string|null $info
     * @param string|null $html
     */
    public function __construct(
        public ?string $id = null,
        public ?string $subtitle = null,
        public ?string $info = null,
        public ?string $html = null
    ) { }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * @param string $info
     */
    public function setInfo(string $info): self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $html
     */
    public function setHtml(string $html): self
    {
        $this->html = $html;
        return $this;
    }

}

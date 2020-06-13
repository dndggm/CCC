<?php
/**
 * @2020 Creative Coffeur Sükrü Demir, Burgsteinfurt
 * http://www.creative-coiffeur.de/
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $start;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $end;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contentFull;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStart(): ?string
    {
        return $this->start;
    }


    /**
     * @param string $start
     * @return Event
     */
    public function setStart(string $start): self
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnd(): ?string
    {
        return $this->end;
    }

    /**
     * @param $end
     * @return Event
     */
    public function setEnd(string $end): self
    {
        $this->end = $end;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return Event
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param $content
     * @return Event
     */
    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentFull(): ?string
    {
        return $this->contentFull;
    }

    /**
     * @param $contentFull
     * @return Event
     */
    public function setContentFull(string $contentFull): self
    {
        $this->contentFull = $contentFull;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return Event
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'start' => $this->start,
            'end' => $this->end,
            'title' => $this->title,
            'content' => $this->content,
            'contentFull' => $this->contentFull,
            'gender' => $this->gender
        ];
    }
}
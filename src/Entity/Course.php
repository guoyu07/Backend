<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Core\Util\StringUtil;
use Persona\Hris\Course\Model\CourseInterface;
use Persona\Hris\Performance\Model\IndicatorInterface;
use Persona\Hris\Share\Model\UniversityInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cr_courses", indexes={@ORM\Index(name="course_search_idx", columns={"name"})})
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={
 *             "order.filter",
 *             "name.search"
 *         },
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @UniqueEntity("name")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class Course implements CourseInterface, ActionLoggerAwareInterface
{
    use ActionLoggerAwareTrait;
    use Timestampable;
    use SoftDeletable;

    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     *
     * @var string
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $name;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $description;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $mentor;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $startDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $endDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\PerformanceIndicator", fetch="EAGER")
     * @ORM\JoinColumn(name="indicator_id", referencedColumnName="id")
     *
     * @var IndicatorInterface
     */
    private $indicator;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\University", fetch="EAGER")
     * @ORM\JoinColumn(name="university_id", referencedColumnName="id")
     *
     * @var UniversityInterface
     */
    private $university;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = StringUtil::uppercase($name);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getMentor(): string
    {
        return $this->mentor;
    }

    /**
     * @param string $mentor
     */
    public function setMentor(string $mentor)
    {
        $this->mentor = $mentor;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return IndicatorInterface
     */
    public function getIndicator(): ? IndicatorInterface
    {
        return $this->indicator;
    }

    /**
     * @param IndicatorInterface $indicator
     */
    public function setIndicator(IndicatorInterface $indicator = null): void
    {
        $this->indicator = $indicator;
    }

    /**
     * @return UniversityInterface
     */
    public function getUniversity(): ? UniversityInterface
    {
        return $this->university;
    }

    /**
     * @param UniversityInterface $university
     */
    public function setUniversity(UniversityInterface $university = null): void
    {
        $this->university = $university;
    }
}

<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles personal delivery data. */
class PersonalDelivery
{
    /** Department delivery (without personal identification) */
    const TYPE_DEPARTMENT_DELIVERY = 1;
    /** Personal delivery with personal identification (ID Check) */
    const TYPE_PERSONAL_DELIVERY_WITH_PERSONAL_IDENTIFICATION = 2;
    /** Personal delivery without personal identification at drop point (e.g. parcel shop) */
    const TYPE_PERSONAL_DELIVERY_WITHOUT_PERSONAL_IDENTIFICATION = 3;
    /** Personal delivery with personal identification at drop point (e.g. parcel shop) */
    const TYPE_PERSONAL_DELIVERY_WITH_PERSONAL_IDENTIFICATION_AT_DROP_POINT = 4;
    /** Personal delivery with personal identification at drop point plus ID-Check (e.g. parcel shop) */
    const TYPE_PERSONAL_DELIVERY_WITH_PERSONAL_IDENTIFICATION_AT_DROP_POINT_PLUS_ID_CHECK = 5;

    const MAX_LENGTH_FLOOR = 30;
    const MAX_LENGTH_BUILDING = 30;
    const MAX_LENGTH_DEPARTMENT = 30;
    const MAX_LENGTH_NAME = 30;
    const MAX_LENGTH_PHONE = 30;
    const MAX_LENGTH_PERSON_ID = 35;

    /**
     * Declares type of personal delivery. Possible values are:
     * 1 = Department delivery (without personal identification),
     * 2 = Personal delivery with personal identification (ID-Check),
     * 3 = Personal delivery without personal identification at drop point (e.g. parcel shop),
     * 4 = Personal delivery with personal identification at drop point (e.g. parcel shop),
     * 5 = Personal delivery with personal identification at drop point plus ID-Check (e.g. parcel shop).
     *
     * For parcel shop delivery the parcel shop id must be declared in productAndServiceData.
     * It can be obtained from parcel shop finder.
     * @var int
     */
    protected int $type;

    /**
     * Floor where the personal delivery shall take place.
     * This field is only used for department delivery.
     * @var string
     */
    protected string $floor;

    /**
     * Building where the personal delivery shall take place.
     * This field is only used for department delivery (type 1).
     * @var string
     */
    protected string $building;

    /**
     * Department where the personal delivery shall take place.
     * This field is only used for department delivery (type 1).
     * @var string
     */
    protected string $department;

    /**
     * Name of the person authorised to accept the consignment.
     * This field is only used for delivery with ID-Check (types 2 and 5).
     * @var string
     */
    protected string $name;

    /**
     * Telephone number of the person authorised to accept the consignment.
     * This field is only used for delivery with ID-Check (types 2 and 5).
     * @var string
     */
    protected string $phone;

    /**
     * Personal identification number of the person authorised to accept the consignment.
     * This field is only used for delivery with ID-Check (types 2 and 5).
     * @var string
     */
    protected string $personId;

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type ?? null;
    }

    /**
     * @param int $type
     * @return static
     * @throws WrongArgumentException
     */
    public function setType(int $type): static
    {
        if (!in_array($type, $allowedList = $this->getAllowedTypeList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed type is %s, entered %s',
                    implode(', ', $allowedList),
                    $type
                )
            );
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Department delivery (without personal identification)
     * @return static
     */
    public function setTypeDepartmentDelivery(): static
    {
        $this->type = self::TYPE_DEPARTMENT_DELIVERY;
        return $this;
    }

    /**
     * Personal delivery with personal identification (ID Check)
     * @return static
     */
    public function setTypePersonalDeliveryWithPersonalIdentification(): static
    {
        $this->type = self::TYPE_PERSONAL_DELIVERY_WITH_PERSONAL_IDENTIFICATION;
        return $this;
    }

    /**
     * Personal delivery without personal identification at drop point (e.g. parcel shop)
     * @return static
     */
    public function setTypePersonalDeliveryWithoutPersonalIdentification(): static
    {
        $this->type = self::TYPE_PERSONAL_DELIVERY_WITHOUT_PERSONAL_IDENTIFICATION;
        return $this;
    }

    /**
     * Personal delivery with personal identification at drop point (e.g. parcel shop)
     * @return static
     */
    public function setTypePersonalDeliveryWithPersonalIdentificationAtDropPoint(): static
    {
        $this->type = self::TYPE_PERSONAL_DELIVERY_WITH_PERSONAL_IDENTIFICATION_AT_DROP_POINT;
        return $this;
    }

    /**
     * Personal delivery with personal identification at drop point plus ID-Check (e.g. parcel shop)
     * @return static
     */
    public function setTypePersonalDelivery(): static
    {
        $this->type = self::TYPE_PERSONAL_DELIVERY_WITH_PERSONAL_IDENTIFICATION_AT_DROP_POINT_PLUS_ID_CHECK;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFloor(): ?string
    {
        return $this->floor ?? null;
    }

    /**
     * @param string $floor
     * @return static
     * @throws WrongArgumentException
     */
    public function setFloor(string $floor): static
    {
        if (mb_strlen($floor) > self::MAX_LENGTH_FLOOR) {
            throw new WrongArgumentException(
                sprintf('max length floor is %d', self::MAX_LENGTH_FLOOR)
            );
        }

        $this->floor = $floor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuilding(): ?string
    {
        return $this->building ?? null;
    }

    /**
     * @param string $building
     * @return static
     * @throws WrongArgumentException
     */
    public function setBuilding(string $building): static
    {
        if (mb_strlen($building) > self::MAX_LENGTH_BUILDING) {
            throw new WrongArgumentException(
                sprintf('max length building is %d', self::MAX_LENGTH_BUILDING)
            );
        }

        $this->building = $building;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepartment(): ?string
    {
        return $this->department ?? null;
    }

    /**
     * @param string $department
     * @return static
     * @throws WrongArgumentException
     */
    public function setDepartment(string $department): static
    {
        if (mb_strlen($department) > self::MAX_LENGTH_DEPARTMENT) {
            throw new WrongArgumentException(
                sprintf('max length department is %d', self::MAX_LENGTH_DEPARTMENT)
            );
        }

        $this->department = $department;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    /**
     * @param string $name
     * @return static
     * @throws WrongArgumentException
     */
    public function setName(string $name): static
    {
        if (mb_strlen($name) > self::MAX_LENGTH_NAME) {
            throw new WrongArgumentException(
                sprintf('max length name is %d', self::MAX_LENGTH_NAME)
            );
        }

        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone ?? null;
    }

    /**
     * @param string $phone
     * @return static
     * @throws WrongArgumentException
     */
    public function setPhone(string $phone): static
    {
        if (mb_strlen($phone) > self::MAX_LENGTH_PHONE) {
            throw new WrongArgumentException(
                sprintf('max length phone is %d', self::MAX_LENGTH_PHONE)
            );
        }

        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPersonId(): ?string
    {
        return $this->personId ?? null;
    }

    /**
     * @param string $personId
     * @return static
     * @throws WrongArgumentException
     */
    public function setPersonId(string $personId): static
    {
        if (mb_strlen($personId) > self::MAX_LENGTH_PERSON_ID) {
            throw new WrongArgumentException(
                sprintf('max length personId is %d', self::MAX_LENGTH_PERSON_ID)
            );
        }

        $this->personId = $personId;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getAllowedTypeList(): array
    {
        return [
            self::TYPE_DEPARTMENT_DELIVERY,
            self::TYPE_PERSONAL_DELIVERY_WITH_PERSONAL_IDENTIFICATION,
            self::TYPE_PERSONAL_DELIVERY_WITHOUT_PERSONAL_IDENTIFICATION,
            self::TYPE_PERSONAL_DELIVERY_WITH_PERSONAL_IDENTIFICATION_AT_DROP_POINT,
            self::TYPE_PERSONAL_DELIVERY_WITH_PERSONAL_IDENTIFICATION_AT_DROP_POINT_PLUS_ID_CHECK
        ];
    }
}
<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles address data. */
class Address
{
    const MAX_LENGTH_NAME1 = 50;
    const MAX_LENGTH_NAME2 = 35;
    const MAX_LENGTH_STREET = 35;
    const MAX_LENGTH_HOUSE_NO = 8;
    CONST MAX_LENGTH_ZIP_CODE = 9;
    const MAX_LENGTH_CITY = 50;
    const MAX_LENGTH_CUSTOMER_NUMBER = 17;
    const MAX_LENGTH_CONTACT = 35;
    const MAX_LENGTH_PHONE = 30;
    const MAX_LENGTH_MOBILE = 30;
    const MAX_LENGTH_FAX = 30;
    const MAX_LENGTH_EMAIL = 100;
    const MAX_LENGTH_COMMENT = 70;
    const MAX_LENGTH_IACCOUNT = 50;

    const MAX_GLN = 9999999999999;

    const PATTERN_STATE = '/^[A-Z]{2}$/u';
    const PATTERN_COUNTRY = '/^[A-Z]{2}$/u';
    const PATTERN_EMAIL = '/^[\w\p{L}!#\$%\&\'*+\/=?^_`\{|\}~\-]+(\.[\w\p{L}!#$%&\'*+\/=?^_`{|}~-]+)*\@[\w][\w\p{L}\-]*(\.[\w\p{L}\-]+)*(\.[a-zA-Z][\-a-zA-Z0-9]{0,61}[a-zA-Z0-9])$/u';

    /**
     * Name of address owner. For dangerous goods the maximum length is 50, otherwise always 35.
     * @var string
     */
    protected string $name1;

    /**
     * Second name of address owner.
     * @var string
     */
    protected string $name2;

    /**
     * Street of address owner. For dangerous goods the maximum length is 50, otherwise always 35.
     * @var string
     */
    protected string $street;

    /**
     * House number of address owner.
     * @var string
     */
    protected string $houseNo;

    /**
     * State of address owner in ISO 3166-2 code (e.g. BY = Bayern).
     * @var string
     */
    protected string $state;

    /**
     * Country of address owner in ISO 3166-1 alpha-2 format (e.g. 'DE').
     * @var string
     */
    protected string $country;

    /**
     * Zip code of address owner.
     * @var string
     */
    protected string $zipCode;

    /**
     * City/town of address owner. For dangerous goods the maximum length is 50, otherwise always 35.
     * @var string
     */
    protected string $city;

    /**
     * International location number of address owner.
     * @var int
     */
    protected int $gln;

    /**
     * Customer number of address owner.
     * Maximum length is 17 for consignment and pickup information, 11 for collection request.
     * Mandatory for sender's address.
     * @var string
     */
    protected string $customerNumber;

    /**
     * Contact person of address owner.
     * @var string
     */
    protected string $contact;

    /**
     * Phone number of address owner. Mandatory if phone is the chosen notification channel.
     * If SMS notification is chosen, either mobile or phone must be filled.
     * @var string
     */
    protected string $phone;

    /**
     * Mobile phone number of address owner.
     * If SMS notification is chosen, either mobile or phone must be filled.
     * @var string
     */
    protected string $mobile;

    /**
     * Fax number of address owner. No required data format.
     * @var string
     */
    protected string $fax;

    /**
     * The email address including at minimum one "@" character as a delimiter between addresser and domain.
     * The domain must include at minimum one "." as a delimiter between domain-name and domain-country.
     * @var string
     */
    protected string $email;

    /**
     * Comment on address owner.
     * @var string
     */
    protected string $comment;

    /**
     * Account allocation or cost center (for VTG) of invoice data for consignments.
     * @var string
     */
    protected string $iaccount;

    /**
     * @return string|null
     */
    public function getName1(): ?string
    {
        return $this->name1 ?? null;
    }

    /**
     * @param string $name1
     * @return static
     * @throws WrongArgumentException
     */
    public function setName1(string $name1): static
    {
        if (mb_strlen($name1) > self::MAX_LENGTH_NAME1) {
            throw new WrongArgumentException(
                sprintf('max length name1 is %d', self::MAX_LENGTH_NAME1)
            );
        }

        $this->name1 = $name1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName2(): ?string
    {
        return $this->name2 ?? null;
    }

    /**
     * @param string $name2
     * @return static
     * @throws WrongArgumentException
     */
    public function setName2(string $name2): static
    {
        if (mb_strlen($name2) > self::MAX_LENGTH_NAME2) {
            throw new WrongArgumentException(
                sprintf('max length name2 is %d', self::MAX_LENGTH_NAME2)
            );
        }

        $this->name2 = $name2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street ?? null;
    }

    /**
     * @param string $street
     * @return static
     * @throws WrongArgumentException
     */
    public function setStreet(string $street): static
    {
        if (mb_strlen($street) > self::MAX_LENGTH_STREET) {
            throw new WrongArgumentException(
                sprintf('max length street is %d', self::MAX_LENGTH_STREET)
            );
        }

        $this->street = $street;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNo(): ?string
    {
        return $this->houseNo ?? null;
    }

    /**
     * @param string $houseNo
     * @return static
     * @throws WrongArgumentException
     */
    public function setHouseNo(string $houseNo): static
    {
        if (mb_strlen($houseNo) > self::MAX_LENGTH_HOUSE_NO) {
            throw new WrongArgumentException(
                sprintf('max length houseNo is %d', self::MAX_LENGTH_HOUSE_NO)
            );
        }

        $this->houseNo = $houseNo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state ?? null;
    }

    /**
     * @param string $state
     * @return static
     * @throws WrongArgumentException
     */
    public function setState(string $state): static
    {
        if (!preg_match(self::PATTERN_STATE, $state)) {
            throw new WrongArgumentException(
                sprintf('state should be ISO 3166-2 format, entered %s', $state)
            );
        }

        $this->state = $state;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country ?? null;
    }

    /**
     * @param string $country
     * @return static
     * @throws WrongArgumentException
     */
    public function setCountry(string $country): static
    {
        if (!preg_match(self::PATTERN_COUNTRY, $country)) {
            throw new WrongArgumentException(
                sprintf('country should be ISO 3166-1 format, entered %s', $country)
            );
        }

        $this->country = $country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode ?? null;
    }

    /**
     * @param string $zipCode
     * @return static
     * @throws WrongArgumentException
     */
    public function setZipCode(string $zipCode): static
    {
        if (mb_strlen($zipCode) > self::MAX_LENGTH_ZIP_CODE) {
            throw new WrongArgumentException(
                sprintf('max length zipCode is %d', self::MAX_LENGTH_ZIP_CODE)
            );
        }

        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city ?? null;
    }

    /**
     * @param string $city
     * @return static
     * @throws WrongArgumentException
     */
    public function setCity(string $city): static
    {
        if (mb_strlen($city) > self::MAX_LENGTH_CITY) {
            throw new WrongArgumentException(
                sprintf('max length city is %d', self::MAX_LENGTH_CITY)
            );
        }

        $this->city = $city;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGln(): ?int
    {
        return $this->gln ?? null;
    }

    /**
     * @param int $gln
     * @return static
     * @throws WrongArgumentException
     */
    public function setGln(int $gln): static
    {
        if ($gln > self::MAX_GLN) {
            throw new WrongArgumentException(
                sprintf('max gln value is %d', self::MAX_GLN)
            );
        }

        $this->gln = $gln;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerNumber(): ?string
    {
        return $this->customerNumber ?? null;
    }

    /**
     * @param string $customerNumber
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomerNumber(string $customerNumber): static
    {
        if (mb_strlen($customerNumber) > self::MAX_LENGTH_CUSTOMER_NUMBER) {
            throw new WrongArgumentException(
                sprintf('max length customerNumber is %d', self::MAX_LENGTH_CUSTOMER_NUMBER)
            );
        }

        $this->customerNumber = $customerNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContact(): ?string
    {
        return $this->contact ?? null;
    }

    /**
     * @param string $contact
     * @return static
     * @throws WrongArgumentException
     */
    public function setContact(string $contact): static
    {
        if (mb_strlen($contact) > self::MAX_LENGTH_CONTACT) {
            throw new WrongArgumentException(
                sprintf('max length contact is %d', self::MAX_LENGTH_CONTACT)
            );
        }

        $this->contact = $contact;
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
    public function getMobile(): ?string
    {
        return $this->mobile ?? null;
    }

    /**
     * @param string $mobile
     * @return static
     * @throws WrongArgumentException
     */
    public function setMobile(string $mobile): static
    {
        if (mb_strlen($mobile) > self::MAX_LENGTH_MOBILE) {
            throw new WrongArgumentException(
                sprintf('max length mobile is %d', self::MAX_LENGTH_MOBILE)
            );
        }

        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFax(): ?string
    {
        return $this->fax ?? null;
    }

    /**
     * @param string $fax
     * @return static
     * @throws WrongArgumentException
     */
    public function setFax(string $fax): static
    {
        if (mb_strlen($fax) > self::MAX_LENGTH_FAX) {
            throw new WrongArgumentException(
                sprintf('max length fax is %d', self::MAX_LENGTH_FAX)
            );
        }

        $this->fax = $fax;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email ?? null;
    }

    /**
     * @param string $email
     * @return static
     * @throws WrongArgumentException
     */
    public function setEmail(string $email): static
    {
        if (!preg_match(self::PATTERN_EMAIL, $email)) {
            throw new WrongArgumentException(
                sprintf('email pattern mismatch, entered %s', $email)
            );
        }

        if (mb_strlen($email) > self::MAX_LENGTH_EMAIL) {
            throw new WrongArgumentException(
                sprintf('max length email is %d', self::MAX_LENGTH_EMAIL)
            );
        }

        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment ?? null;
    }

    /**
     * @param string $comment
     * @return static
     * @throws WrongArgumentException
     */
    public function setComment(string $comment): static
    {
        if (mb_strlen($comment) > self::MAX_LENGTH_COMMENT) {
            throw new WrongArgumentException(
                sprintf('max length comment is %d', self::MAX_LENGTH_COMMENT)
            );
        }

        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIaccount(): ?string
    {
        return $this->iaccount ?? null;
    }

    /**
     * @param string $iaccount
     * @return static
     * @throws WrongArgumentException
     */
    public function setIaccount(string $iaccount): static
    {
        if (mb_strlen($iaccount) > self::MAX_LENGTH_IACCOUNT) {
            throw new WrongArgumentException(
                sprintf('max length iaccount is %d', self::MAX_LENGTH_IACCOUNT)
            );
        }

        $this->iaccount = $iaccount;
        return $this;
    }
}
<?php

namespace App\Dtos;

use App\Http\Requests\RegisterUserRequest;
use App\Interfaces\DtoInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class UserDto implements DtoInterface
{
    private ?int $id;
    private string $email;
    private string $name;
    private string $phoneNumber;
    private string $password;
    private ?string $pin;
    private ?Carbon $createdAt;
    private ?Carbon $updatedAt;


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of phone_number
     */ 
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phone_number
     *
     * @return  self
     */ 
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of pin
     */ 
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set the value of pin
     *
     * @return  self
     */ 
    public function setPin($bin)
    {
        $this->pin = $bin;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public static function fromApiFormRequest(RegisterUserRequest|FormRequest $request): self{
        
        $userDto = new UserDto();

        $userDto->setName($request->name);
        $userDto->setEmail($request->email);
        $userDto->setPassword($request->password);
        $userDto->setPhoneNumber($request->phone_number);
        
        return $userDto;

    }

    public static function fromModel(User|Model $model): UserDto {

        $userDto = new UserDto();

        $userDto->setId($model->id);
        $userDto->setName($model->name);
        $userDto->setEmail($model->email);
        $userDto->setPhoneNumber($model->phone_number);
        $userDto->setPassword($model->password);
        $userDto->setPin($model->pin);
        $userDto->setCreatedAt($model->createdAt);
        $userDto->setUpdatedAt($model->updatedAt);

        return $userDto;
    }

    public static function toArray(User|Model $model): array{
        return [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'phone_number' => $model->phone_number,
            'created_at' => $model->createdAt,
            'updated_at' => $model->updatedAt
        ];
    }

}

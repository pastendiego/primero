<?php
namespace Diego\StoreBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Diego\StoreBundle\Entity\ProductRepository")
 */
 

class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
 
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(min = "3",groups={"registration"})
     * 
     */
    protected $name;
 
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price;
 
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(groups={"registration2"})
     */
    protected $description;
    
     /**
      * 
      * @ORM\Column(type="string", length=20)
     * @Assert\Choice(
     *     choices = { "male", "female" },
     *     message = "Choose a valid gender."
     * )
     */
    protected $gender;
    
    
    protected $category;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param \Diego\StoreBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Diego\StoreBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Diego\StoreBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Product
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }
    
     /**
     * @Assert\True(message = "The password cannot match your first name",groups={"registration"})
     */
    public function isPasswordLegal()
    {
        return ($this->name != $this->description);
    }
}

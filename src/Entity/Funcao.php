<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Funcao
 *
 * @ORM\Table(name="FUNCAO")
 * @ORM\Entity
 */
class Funcao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CO_FUNCAO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_FUNCAO", type="string", length=60, nullable=false)
     */
    private $nome;

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
     * Set nome
     *
     * @param  string $nome
     * @return Funcao
     */
    public function setNome($nome)
    {
        $this->nome = ($nome);

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return ($this->nome);
    }

    /**
     * Sets the value of id.
     *
     * @param integer $id the id funcao
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the string of object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nome;
    }
}

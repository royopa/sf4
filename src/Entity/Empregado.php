<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empregado
 *
 * @ORM\Table(name="EMPREGADO")
 * @ORM\Entity
 */
class Empregado
{
    /**
     * @var string
     *
     * @ORM\Column(name="CO_EMPREGADO", type="string", length=7, nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_EMPREGADO", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param  string    $nome
     * @return Empregado
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
     * @param string $id the co empregado
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = ($id);

        return $this;
    }

    /**
     * Get the string of object
     *
     * @return string
     */
    public function __toString()
    {
        return ($this->nome);
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->id;
    }
}

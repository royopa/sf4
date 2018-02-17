<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unidade
 *
 * @ORM\Table(name="UNIDADE")
 * @ORM\Entity
 */
class Unidade
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CO_UNIDADE", type="integer", nullable=false)
     * @ORM\Id
     * 
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_UNIDADE", type="string", length=60, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_SIGLA", type="string", length=5, nullable=false)
     */
    private $sigla;

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
     * Get código/id
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param  string  $nome
     * @return Unidade
     */
    public function setNome($nome)
    {
        $this->nome = ($nome);

        return $this;
    }

    /**
     * Get noUnidade
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
     * @param integer $id the id unidade
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
        return ($this->id . ' - ' . $this->sigla . ' - ' . $this->nome);
    }

    /**
     * Gets the value of noSigla.
     *
     * @return string
     */
    public function getSigla()
    {
        return ($this->sigla);
    }

    /**
     * Sets the value of sigla.
     *
     * @param string $sigla the sigla
     *
     * @return self
     */
    public function setSigla($sigla)
    {
        $this->sigla = ($sigla);

        return $this;
    }

    public function __construct()
    {
    }
}

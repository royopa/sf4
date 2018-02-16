<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table(name="DOCUMENTO_STATUS")
 * @ORM\Entity
 */
class DocumentoStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CO_DECISAO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_DECISAO", type="string", length=40, nullable=false)
     */
    private $nome;

    /**
     * Get coComiteTipo
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set noComiteTipo
     *
     * @param  string     $nome
     * @return Status
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get noComiteTipo
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Get noComite toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nome;
    }

    /**
     * Sets the value of id.
     *
     * @param integer $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}

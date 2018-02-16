<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentoTipo
 *
 * @ORM\Table(name="DOCUMENTO_TIPO")
 * @ORM\Entity
 */
class DocumentoTipo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CO_DOC_TIPO", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NO_DOC_TIPO", type="string", length=20, nullable=false)
     */
    private $nome;

    /**
     * Get coDocTipo
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
     * @param  string        $nome
     * @return DocumentoTipo
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Get string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nome;
    }
}

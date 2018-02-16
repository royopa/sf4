<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Documento
 *
 * @ORM\Table(name="DOCUMENTO")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Documento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CO_DOC", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="NU_DOC", type="integer", nullable=true)
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="AA_DOC", type="integer", nullable=true)
     */
    private $ano;

    /**
     * @var string
     *
     * @ORM\Column(name="DE_EMENTA", type="text", length=1000, nullable=true)
     */
    private $ementa;

    /**
     * @var string
     *
     * @ORM\Column(name="ED_DOC", type="string", length=1000, nullable=true)
     */
    private $endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="DE_MOTIVO", type="text", length=1000, nullable=true)
     */
    private $motivo;

    /**
     * @var \App\Entity\DocumentoTipo
     *
     * @ORM\ManyToOne(targetEntity="DocumentoTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CO_DOC_TIPO", referencedColumnName="CO_DOC_TIPO")
     * })
     */
    private $tipo;

    /**
     * @var \App\Entity\Unidade
     *
     * @ORM\ManyToOne(targetEntity="Unidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CO_UNIDADE", referencedColumnName="CO_UNIDADE")
     * })
     */
    private $unidade;

    /**
     * @var \App\Entity\DocumentoStatus
     *
     * @ORM\ManyToOne(targetEntity="DocumentoStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CO_DECISAO", referencedColumnName="CO_DECISAO")
     * })
     */
    private $status;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(name="DT_CADASTRO", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IC_CONCLUIDO", type="boolean", nullable=true)
     */
    private $isConcluido;

    /**
     * @var string
     *
     * @ORM\Column(name="DE_PROJETO", type="string", length=100, nullable=true)
     */
    private $projeto;

    /**
     * @Assert\File(maxSize="15000000")
     */
    private $file;

    /**
     * @var string $filename
     *
     */
    private $filename;

    /**
     * Sets file.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return null|\Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFilename()
        );

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        //$this->setUpdated(date('Y-m-d H:i:s'));
        $this->setUpdated(new \DateTime('now'));
    }

    public function getAbsolutePath()
    {
        return null === $this->endereco
            ? null
            : $this->getUploadRootDir().'/'.$this->endereco;
    }

    public function getWebPath()
    {
        return null === $this->endereco
            ? null
            : $this->getUploadDir().'/'.$this->endereco;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {

            $this->refreshUpdated();

            // set the path property to the filename where you've saved the file
            $this->endereco = $this->getUploadDir() . '/' . $this->getFilename();
        }
    }

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        $this->refreshUpdated();
    }

    /**
     * Gets the value of updated.
     *
     * @return \DateTime $updated
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Sets the value of updated.
     *
     * @param \DateTime $updated $updated the updated
     *
     * @return self
     */
    public function setUpdated($updated)
    {
        if (null === $updated) {
            $updated = new \DateTime("now");
        }
        $this->updated = $updated;

        return $this;
    }

    /**
     * Gets the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * Gets the value of numero.
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Gets the value of numero formatado com três dígitos.
     *
     * @return string
     */
    public function getNumeroFormatado()
    {
        return str_pad($this->numero, 3, "0", STR_PAD_LEFT);
    }

    /**
     * Sets the value of numero.
     *
     * @param integer $numero the numero
     *
     * @return self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Gets the value of ano.
     *
     * @return integer
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Sets the value of ano.
     *
     * @param integer $ano the ano
     *
     * @return self
     */
    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * Gets the value of ementa.
     *
     * @return string
     */
    public function getEmenta()
    {
        return ($this->ementa);
    }

    /**
     * Sets the value of ementa.
     *
     * @param string $ementa the ementa
     *
     * @return self
     */
    public function setEmenta($ementa)
    {
        $this->ementa = ($ementa);

        return $this;
    }

    /**
     * Gets the value of endereco.
     *
     * @return string
     */
    public function getEndereco()
    {
        return ($this->endereco);
    }

    /**
     * Sets the value of endereco.
     *
     * @param string $endereco the endereco
     *
     * @return self
     */
    public function setEndereco($endereco)
    {
        $this->endereco = ($endereco);

        return $this;
    }

    /**
     * Gets the value of motivo.
     *
     * @return string
     */
    public function getMotivo()
    {
        return ($this->motivo);
    }

    /**
     * Sets the value of motivo.
     *
     * @param string $motivo the motivo
     *
     * @return self
     */
    public function setMotivo($motivo)
    {
        $this->motivo = ($motivo);

        return $this;
    }

    /**
     * Gets the value of comite.
     *
     * @return mixed
     */
    public function getComite()
    {
        return $this->comite;
    }

    /**
     * Sets the value of comite.
     *
     * @param mixed $comite the comite
     *
     * @return self
     */
    public function setComite($comite)
    {
        $this->comite = $comite;

        return $this;
    }

    /**
     * Gets the }).
     *
     * @return \App\Entity\DocumentoTipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Sets the }).
     *
     * @param \App\Entity\DocumentoTipo $tipo the tipo
     *
     * @return self
     */
    public function setTipo(\App\Entity\DocumentoTipo $tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Gets the }).
     *
     * @return \App\Entity\Documento
     */
    public function getDocumentoReferencia()
    {
        return $this->documentoReferencia;
    }

    /**
     * Sets the }).
     *
     * @param \App\Entity\Documento $documentoReferencia the documento referencia
     *
     * @return self
     */
    public function setDocumentoReferencia($documentoReferencia)
    {
        $this->documentoReferencia = $documentoReferencia;

        return $this;
    }

    /**
     * Gets the Unidade
     *
     * @return \App\Entity\Unidade
     */
    public function getUnidade()
    {
        return $this->unidade;
    }

    /**
     * Sets the Unidade.
     *
     * @param \App\Entity\Unidade $unidade the documento referencia
     *
     * @return self
     */
    public function setUnidade(\App\Entity\Unidade $unidade)
    {
        $this->unidade = $unidade;

        return $this;
    }

    /**
     * Get Documento toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->tipo . ' - ' . $this->numero . '/' . $this->ano . ' - ' . $this->unidade;
    }

    public function __construct()
    {
        $this->unidadesProponentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->produtosVinculados  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participantesContra = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Gets the joinColumns={@ORM\JoinColumn(name="CO_DOC", referencedColumnName="CO_DOC")},
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUnidadesProponentes()
    {
        return $this->unidadesProponentes;
    }

    /**
     * Sets the joinColumns={@ORM\JoinColumn(name="CO_DOC", referencedColumnName="CO_DOC")},
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $unidadesProponentes the unidades proponentes
     *
     * @return self
     */
    public function setUnidadesProponentes(\Doctrine\Common\Collections\ArrayCollection $unidadesProponentes)
    {
        $this->unidadesProponentes = $unidadesProponentes;

        return $this;
    }

    /**
     * Gets the }).
     *
     * @return \App\Entity\DocumentoStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the }).
     *
     * @param \App\Entity\DocumentoStatus $status the status
     *
     * @return self
     */
    public function setStatus(\App\Entity\DocumentoStatus $status)
    {
        $this->status = $status;

        return $this;
    }

    public function getFilename()
    {
        if (null === $this->filename) {
            //gera um nome de arquivo único
            $nomeUnico = sha1(uniqid(mt_rand(), true));
            $nomeUnico = $nomeUnico.'.'.$this->file->guessExtension();
            $this->filename = $this->getComite()->getId().'_'.$this->id.'_'.$nomeUnico;
        }

        return $this->filename;
    }

    /**
     * Gets the getProdutosVinculados
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProdutosVinculados()
    {
        return $this->produtosVinculados;
    }

    /**
     * Sets the getProdutosVinculados
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $produtosVinculados the produtos vinculados
     *
     * @return self
     */
    public function setProdutosVinculados(\Doctrine\Common\Collections\ArrayCollection $produtosVinculados)
    {
        $this->produtosVinculados = $produtosVinculados;

        return $this;
    }

    /**
     * Sets the value of filename.
     *
     * @param string $filename $filename the filename
     *
     * @return self
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Gets the value of isConcluido.
     *
     * @return boolean
     */
    public function getIsConcluido()
    {
        return $this->isConcluido;
    }

    /**
     * Gets the value of isConcluido.
     *
     * @return boolean
     */
    public function isConcluido()
    {
        return $this->isConcluido;
    }

    /**
     * Sets the value of isConcluido.
     *
     * @param boolean $isConcluido the is concluido
     *
     * @return self
     */
    public function setIsConcluido($isConcluido)
    {
        $this->isConcluido = $isConcluido;

        return $this;
    }

    /**
     * Gets the value of isVotoContra.
     *
     * @return boolean
     */
    public function getIsVotoContra()
    {
        return $this->isVotoContra;
    }

    /**
     * Sets the value of isVotoContra.
     *
     * @param boolean $isVotoContra the is voto contra
     *
     * @return self
     */
    public function setIsVotoContra($isVotoContra)
    {
        $this->isVotoContra = $isVotoContra;

        return $this;
    }

    /**
     * Gets the joinColumns={@ORM\JoinColumn(name="CO_DOC", referencedColumnName="CO_DOC")},
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getParticipantesContra()
    {
        return $this->participantesContra;
    }

    /**
     * Sets the joinColumns={@ORM\JoinColumn(name="CO_DOC", referencedColumnName="CO_DOC")},
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $participantesContra the participantes contra
     *
     * @return self
     */
    public function setParticipantesContra(\Doctrine\Common\Collections\ArrayCollection $participantesContra)
    {
        $this->participantesContra = $participantesContra;

        return $this;
    }

    /**
    * Verifica se o documento pode ser editado
    *
    *
    * @return boolean
    */
    public function canBeEdited()
    {
        if (!$this->comite) {
            return false;
        }

        if (!$this->comite->getStatus()) {
            return false;
        }

        //o documento não pode ser editado se o seu comitê
        //tiver concluído/em homologação/pendente
        if ($this->comite->getStatus() == 'Em Homologação') {
            return false;
        }

        if ($this->comite->getStatus() == 'Concluído') {
            return false;
        }

        return true;
    }

    /**
     * Gets the }).
     *
     * @return \App\Entity\CategoriaAssunto
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Sets the }).
     *
     * @param \App\Entity\CategoriaAssunto $categoria the categoria
     *
     * @return self
     */
    public function setCategoria(\App\Entity\CategoriaAssunto $categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getFilenameImport(\SplFileInfo $file)
    {
        //gera um nome de arquivo único
        $nomeUnico = sha1(uniqid(mt_rand(), true));
        $nomeUnico = $nomeUnico.'.'.$file->getExtension();
        $nomeUnico = $this->getComite()->getId().'_'.$this->id.'_'.$nomeUnico;

        return $nomeUnico;
    }

    /**
     * Gets the value of projeto.
     *
     * @return string
     */
    public function getProjeto()
    {
        return $this->projeto;
    }

    /**
     * Sets the value of projeto.
     *
     * @param string $projeto the projeto
     *
     * @return self
     */
    public function setProjeto($projeto)
    {
        $this->projeto = $projeto;

        return $this;
    }
}

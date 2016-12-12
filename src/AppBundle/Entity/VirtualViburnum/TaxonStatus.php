<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaxonStatus
 *
 * @ORM\Table(name="taxon_statuses", indexes={@ORM\Index(name="status", columns={"status_name"})})
 * @ORM\Entity
 */
class TaxonStatus
{
	const ACCEPTED = 'accepted';
	
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="taxon_statuses_id", type="integer", nullable=false)
     */
    private $taxonStatusesId;

    /**
     * @var string
     *
     * @ORM\Column(name="status_name", type="string", length=30, nullable=false)
     */
    private $statusName;

    /**
     * @var string
     *
     * @ORM\Column(name="definition", type="string", length=200, nullable=false)
     */
    private $definition;


}


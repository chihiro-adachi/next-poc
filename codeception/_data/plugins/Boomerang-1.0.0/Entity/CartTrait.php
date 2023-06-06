<?php

namespace Plugin\Boomerang\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
 * @EntityExtension("Eccube\Entity\Cart")
 */
trait CartTrait
{
    /**
     * @var boolean
     */
    #[ORM\Column(name: 'is_boomerang', type: 'boolean', options: ['default' => false], nullable: true)]
    public $is_boomerang;

    /**
     * @var Bar
     */
    #[ORM\JoinColumn(name: 'bar_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity: 'Plugin\Boomerang\Entity\Bar')]
    public $bar;
}

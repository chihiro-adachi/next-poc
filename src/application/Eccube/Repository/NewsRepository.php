<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Eccube\ORM\Exception\ForeignKeyConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;
use Eccube\Entity\News;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends AbstractRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    /**
     * 新着情報を登録します.
     *
     * @param $News
     */
    public function save($News)
    {
        $em = $this->getEntityManager();
        $em->persist($News);
        $em->flush();
    }

    /**
     * 新着情報を削除します.
     *
     * @param News $News
     *
     * @throws ForeignKeyConstraintViolationException 外部キー制約違反の場合
     */
    public function delete($News)
    {
        $em = $this->getEntityManager();
        $em->remove($News);
        $em->flush();
    }

    /**
     * @return \Eccube\ORM\QueryBuilder
     */
    public function getQueryBuilderAll()
    {
        $qb = $this->createQueryBuilder('n');
        $qb->orderBy('n.publish_date', 'DESC')
            ->addOrderBy('n.id', 'DESC');

        return $qb;
    }

    /**
     * @return News[]|ArrayCollection
     */
    public function getList()
    {
        // second level cacheを効かせるためfindByで取得
        $Results = $this->findBy(['visible' => true], ['publish_date' => 'DESC', 'id' => 'DESC']);

        // 公開日時前のNewsをフィルター
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->lte('publish_date', new \DateTime()));

        $News = new ArrayCollection($Results);

        return $News->matching($criteria);
    }
}

<?php

namespace Access\Model;

use Doctrine\ORM\EntityManager;

abstract class AbstractModel
{
    /**
     * @var string
     */
    protected $entity = "";
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;
	/**
	 *
	 * @var EntityManager
	 */
    private $entityManager;

    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Doctrine\ORM\EntityRepository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        $this->repository = $this->entityManager->getRepository($this->entity);

        return $this->repository;
    }



}

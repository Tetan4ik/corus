<?php

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

/**
 * @Entity
 * @Table(name="thank")
 */
Class Thank
{

    /**
     * @id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="userFromId", referencedColumnName="id")
     */
    protected $userFromId;

    /**
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="userToId", referencedColumnName="id")
     */
    protected $userToId;

    /**
     * @OneToOne(targetEntity="User")
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $date;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserFromId()
    {
        return $this->userFromId;
    }

    /**
     * @param mixed $userFromId
     */
    public function setUserFromId($userFromId)
    {
        $this->userFromId = $userFromId;
    }

    /**
     * @return mixed
     */
    public function getUserToId()
    {
        return $this->userToId;
    }

    /**
     * @param mixed $userToId
     */
    public function setUserToId($userToId)
    {
        $this->userToId = $userToId;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param $qb QueryBuilder
     * @param $userName
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getByName($qb, $userName)
    {

        $qb->select('u')
            ->from('User', 'u')
            ->where('u.name = :userName')
            ->setParameter('userName', $userName);

        return $qb->getQuery()->getOneOrNullResult();

    }

    /**
     * @param $targetEntity
     * @param $qb QueryBuilder
     */
    public function onBeforeGetData($targetEntity, &$qb)
    {
        $qb->select('count(u.name) as count')
            ->from('Thank', 't');
    }

    /**
     * @param $targetEntity
     * @param $result QueryBuilder
     * @param $pageSize
     * @return mixed
     */
    public function onAfterGetData($targetEntity, $result, $pageSize)
    {

        //maybe it must be not here
        $curPage = $_GET['current_page'];

        $result->addSelect('u.name');
        $result->groupBy('t.userToId');
        $result->orderBy('count','DESC');
        $result->setMaxResults($pageSize);

        //get pager
        $paginator  = new \Doctrine\ORM\Tools\Pagination\Paginator($result);
        $totalItems = $paginator->count();
        $pageSize =  $pageSize ? $pageSize : 20;
        $currentPage = $curPage ? $curPage : 1;

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($currentPage - 1))
            ->setMaxResults($pageSize);

        //return array because it is easier
        return array("ITEMS"=>$paginator->getQuery()->execute(),"TOTAL_ITEMS"=>$totalItems,"CUR_PAGE"=>$currentPage,"PAGE_SIZE"=>$pageSize);
    }

    /**
     * @param $params
     * @param $qb
     * @param $em
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function setSqlFilter($params, &$qb, $em)
    {

        //set for all because we in a User class
        $qb->innerJoin('user', 'u', Join::WITH, 'u.id = t.userToId');

        if ($params['department']) {
            //find by department.id
            $this->getVotesByDepartmentId($params['department'], $qb);
        }

        if ($params['whomSay']) {
            //get user by name and after find by user.id
            $user = $this->getByName($em->createQueryBuilder(), $params['whomSay']);
            $this->getByUserNameWhomSay($user, $qb);
        }

        if ($params['whoSay']) {
            //get user by name and after find by user.id
            $user = $this->getByName($em->createQueryBuilder(), $params['whoSay']);
            $this->getByUserNameWhoSay($user, $qb);
        }

        if ($params['date-thanks']) {

            $params['date-thanks'] = explode(' - ', $params['date-thanks']);

            $arInterval = array(
                "from" => date("Y-m-d H:i:s", strtotime($params['date-thanks'][0])),
                "to" => date("Y-m-d H:i:s", strtotime($params['date-thanks'][1]))
            );
            //set interval
            $this->getByInterval($arInterval, $qb);
        }
    }

    /**
     * @param $interval
     * @param QueryBuilder $qb
     */
    public function getByInterval($interval, QueryBuilder &$qb)
    {

        if (!empty($interval)) {

            if (isset($interval['from'])) {

                $qb->andWhere('t.date > :dateFrom');
                $fromTime = new \DateTime($interval['from']);
                $qb->setParameter('dateFrom', $fromTime);
            }

            if (isset($interval['to'])) {

                $qb->andWhere('t.date < :dateTo');
                $fromTime = new \DateTime($interval['to']);
                $qb->setParameter('dateTo', $fromTime);
            }
        }
    }

    /**
     * @param $user
     * @param QueryBuilder $qb
     */
    public function getByUserNameWhoSay($user, QueryBuilder &$qb)
    {

        $this->getByUserName("userFromId", $user, $qb);

    }

    /**
     * @param $user
     * @param QueryBuilder $qb
     */
    public function getByUserNameWhomSay($user, QueryBuilder &$qb)
    {

        $this->getByUserName("userToId", $user, $qb);

    }

    /**
     * @param $filed
     * @param $user
     * @param $qb
     */
    protected function getByUserName($filed, $user, &$qb)
    {

        if (is_string($user) || $user instanceof User) {
            if ($user instanceof User)
                $userId = $user->getId();
            else
                $userId = $user;

            $qb->andWhere('t.' . $filed . ' = :userId')
                ->setParameter('userId', $userId);
        }
    }

    /**
     * @param $id
     * @param QueryBuilder $qb
     */
    public function getVotesByDepartmentId($id, QueryBuilder &$qb)
    {

        if (intval($id)) {
            $qb->innerJoin('UserDepartment', 'ud', Join::WITH, 'ud.userId = u.id')
                ->innerJoin('Department', 'd', Join::WITH, 'ud.departmentId = d.id')
                ->andWhere('d.id = :department')
                ->setParameter('department', $id);

        }

    }
}

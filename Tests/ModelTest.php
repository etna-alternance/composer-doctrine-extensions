<?php

namespace Tests;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->model    = new Model();
        $this->date     = date('Y-m-d H:i:s');
        $this->datetime = new \DateTime($this->date);
    }

    public function testNewEntity()
    {
        $this->assertEquals(null, $this->model->getId());
        $this->assertEquals(null, $this->model->getCreatedAt());
        $this->assertEquals(null, $this->model->getUpdatedAt());
        $this->assertEquals(null, $this->model->getDeletedAt());
    }

    public function testPopulatedEntity()
    {
        // Vérification des Getter sur des strings
        $this->model->populate($this->date);
        $this->assertEquals($this->date, $this->model->getCreatedAt());
        $this->assertEquals($this->date, $this->model->getUpdatedAt());
        $this->assertEquals($this->date, $this->model->getDeletedAt());

        // Vérification des Getter sur des objects
        $this->model->populate($this->datetime);
        // Avec format
        $this->assertEquals($this->date, $this->model->getCreatedAt('Y-m-d H:i:s'));
        $this->assertEquals($this->date, $this->model->getUpdatedAt('Y-m-d H:i:s'));
        $this->assertEquals($this->date, $this->model->getDeletedAt('Y-m-d H:i:s'));
        $this->assertEquals(substr($this->date, 0, 10), $this->model->getCreatedAt('Y-m-d'));
        $this->assertEquals(substr($this->date, 0, 10), $this->model->getUpdatedAt('Y-m-d'));
        $this->assertEquals(substr($this->date, 0, 10), $this->model->getDeletedAt('Y-m-d'));

        // Sans format
        $this->assertEquals($this->datetime, $this->model->getUpdatedAt());
        $this->assertEquals($this->datetime, $this->model->getCreatedAt());
        $this->assertEquals($this->datetime, $this->model->getDeletedAt());
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage ETNA\Doctrine\Extensions\AutoIncrementID::setId : method not implemented
     */
    public function testExceptionOnSetId()
    {
        $this->model->setId(2);
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage created_at is not a datetime
     */
    public function testExceptionOnGetCreated_at()
    {
        // Remplis les dates du model avec le model au lieu d'un Datetime
        $this->model->populate($this->model);
        $this->model->getCreatedAt();
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage updated_at is not a datetime
     */
    public function testExceptionOnGetUpdated_at()
    {
        // Remplis les dates du model avec le model au lieu d'un Datetime
        $this->model->populate($this->model);
        $this->model->getUpdatedAt();
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage deleted_at is not a datetime
     */
    public function testExceptionOnGetDeleted_at()
    {
        // Remplis les dates du model avec le model au lieu d'un Datetime
        $this->model->populate($this->model);
        $this->model->getDeletedAt();
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage bad deleted_at provided
     */
    public function testExceptionOnSetDeleted_at()
    {
        $this->model->setDeletedAt(date('Y-m-d'));
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Cannot delete Tests\Model
     */
    public function testExceptionOnDocanDeleted()
    {
        $this->model->canNotDelete();
    }

    public function testSetCreatedAt()
    {
        $this->model->setCreatedAtBeforePersist();
        $this->assertEquals(date('Y-m-d H:i:s'), $this->model->getCreatedAt('Y-m-d H:i:s'));
    }

    public function testSetUpdatedAt()
    {
        $this->model->setUpdatedAtBeforePersist();
        $this->assertEquals(date('Y-m-d H:i:s'), $this->model->getUpdatedAt('Y-m-d H:i:s'));

        $this->model->setUpdatedAtBeforeUpdate();
        $this->assertEquals(date('Y-m-d H:i:s'), $this->model->getUpdatedAt('Y-m-d H:i:s'));
    }

    public function testSetDeletedAt()
    {
        $this->model->setDeletedAt($this->date);
        // On récupère une string
        $this->assertEquals($this->date, $this->model->getDeletedAt('Y-m-d H:i:s'));
        // On récupère un objet
        $this->assertEquals($this->datetime, $this->model->getDeletedAt());
    }
}

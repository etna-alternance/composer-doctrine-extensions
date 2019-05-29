<?php

namespace Tests;

class ModelTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
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
    public function testExceptionOncanNotDeleted()
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
        $this->model->setUpdatedAt();
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

    public function testSetProperties()
    {
        $this->assertEquals($this->model->getModelValue(), '');
        $this->model->setProperties(["model_value" => "super value"]);
        $this->assertEquals($this->model->getModelValue(), "super value");
    }

    public function testModelService()
    {
        $doctrine_fake_metas = new \stdClass();
        $validation_fake_metas = new \stdClass();
        $fake_constraints = new \stdClass();
        $fake_constraints->constraintsByGroup = [
            "create" => []
        ];

        $validation_fake_metas->members = [
            "model_value" => [$fake_constraints],
            "created_at"  => [$fake_constraints]
        ];

        $doctrine_fake_metas->fieldMappings = [
            "model_value" => ["fieldName" => "model_value", "type" => "string"],
            "created_at"  => ["fieldName" => "created_at",  "type" => "datetime"],
            "updated_at"  => ["fieldName" => "updated_at",  "type" => "datetime"],
            "deleted_at"  => ["fieldName" => "deleted_at",  "type" => "datetime"],
        ];

        $em = $this->createMock(\Doctrine\ORM\EntityManager::class);
        $em->method('getClassMetadata')->willReturn($doctrine_fake_metas);
        $validator = $this->createMock(\Symfony\Component\Validator\Validator\RecursiveValidator::class);
        $validator->method('getMetadataFor')->willReturn($validation_fake_metas);
        $model_service = new ModelService($em, $validator);

        $model = $model_service->create([
            'model_value'   => 'je suis une super valeur',
            'useless_value' => 'mais moi je sers a rien',
            'created_at'    => '2012-12-21 12:12:12',
            'updated_at'    => 'j\'suis trop un hacker'
        ]);

        $this->assertEquals($model->getModelValue(), 'je suis une super valeur');
        $this->assertEquals($model->getCreatedAt('Y-m-d H:i:s'), '2012-12-21 12:12:12');
    }
}

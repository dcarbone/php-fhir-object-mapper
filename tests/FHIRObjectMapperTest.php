<?php

/**
 * Class FHIRObjectMapperTest
 */
class FHIRObjectMapperTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $_outputDir;

    /**
     * Setup Test Class
     */
    protected function setup()
    {
        $this->_outputDir = __DIR__.'/output/';

        if (!is_dir($this->_outputDir) && !(bool)@mkdir($this->_outputDir))
            throw new \RuntimeException('Unable to create output dir for tests.');

        foreach(glob($this->_outputDir.'*.php') as $removeMe)
        {
            unlink($removeMe);
        }
    }

    /**
     * @covers \FHIR\ObjectMapper\FHIRObjectMapper::__construct
     * @return \FHIR\ObjectMapper\FHIRObjectMapper
     */
    public function testCanInitializeObjectMapper()
    {
        $mapper = new \FHIR\ObjectMapper\FHIRObjectMapper(
            __DIR__.'/../vendor/php-fhir/elements/src/',
            __DIR__.'/../vendor/php-fhir/resources/src/',
            $this->_outputDir
        );

        $this->assertInstanceOf('\\FHIR\\ObjectMapper\\FHIRObjectMapper', $mapper);

        return $mapper;
    }

    /**
     * @covers \FHIR\ObjectMapper\FHIRObjectMapper::generatePropertyMapClass
     * @covers \FHIR\ObjectMapper\FHIRObjectMapper::createMapEntry
     * @depends testCanInitializeObjectMapper
     * @param \FHIR\ObjectMapper\FHIRObjectMapper $mapper
     */
    public function testCanCreateMapClass(\FHIR\ObjectMapper\FHIRObjectMapper $mapper)
    {
        $this->assertTrue($mapper->generatePropertyMapClass());
        $this->assertFileExists($this->_outputDir.'FHIRObjectClassPropertyMap.php');
    }
}

<?php
namespace Aviogram\InfluxDB;

use Aviogram\Common\ArrayUtils;
use Aviogram\Common\Hydrator\ByConfig;
use Aviogram\Common\Hydrator\ByConfigBuilder;
use Aviogram\InfluxDB\Entity;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class AbstractApi
{
    /**
     * @var ClientRequest
     */
    private $request;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ClientRequest   $request
     * @param LoggerInterface $logger
     */
    public function __construct(ClientRequest $request, LoggerInterface $logger = null)
    {
        $this->request = $request;
        $this->logger  = $logger ?: new NullLogger();
    }

    /**
     * @return ClientRequest
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Abstract method for querying InfluxDB
     *
     * @param string          $query
     * @param ByConfigBuilder $valuesConfig Override the values section of the hydration
     *
     * @return Entity\Result
     */
    protected function query($query, ByConfigBuilder $valuesConfig = null)
    {
        $results = $this->getRequest()
            ->request(
                '/query',
                $this->getRequest()->query()->addQueryPart('q', $query),
                null
            );

        foreach ($results as $mainOffset => $result) {
            $series = ArrayUtils::targetGet('series', $result, array());

            foreach ($series as $offset => $serie) {
                $columns = ArrayUtils::targetGet('columns', $serie);
                $values = ArrayUtils::targetGet('values', $serie, array());
                $tags = ArrayUtils::targetGet('tags', $serie, array());

                foreach ($values as $index => $value) {
                    $values[$index] = array_combine($columns, $value);
                }

                $series[$offset] = array(
                    'tags'   => $tags,
                    'values' => $values
                );
            }

            $results[$mainOffset]['series'] = $series;
        }

        /** @var \Aviogram\InfluxDB\Collection\Result $return */
        $collection = ByConfig::hydrate($results, $this->getDefaultHydrateConfig($valuesConfig));
        $result     = $collection->current();

        // Log the error
        if ($result->hasError() === true) {
            $this->getLogger()->error($result->getError());
        }

        return $result;
    }

    /**
     * Creates a config builder for the query
     *
     * @param  $className
     *
     * @return ByConfigBuilder
     */
    protected function getValueBuilder($className)
    {
        return ByConfig::getConfigBuilder($className, true, 'Aviogram\InfluxDB\Collection\Values');
    }

    /**
     *
     * @param  ByConfigBuilder $valuesConfig
     *
     * @return ByConfigBuilder
     */
    private function getDefaultHydrateConfig(ByConfigBuilder $valuesConfig = null)
    {
        $seriesConfig = ByConfig::getConfigBuilder(
            'Aviogram\InfluxDB\Entity\Serie',
            true,
            'Aviogram\InfluxDB\Collection\Series'
        );

        $tagsConfig = ByConfig::getConfigBuilder(
            null,
            true,
            'Aviogram\InfluxDB\Collection\Tags'
        );

        if ($valuesConfig === null) {
            $valuesConfig = ByConfig::getConfigBuilder(
                'Aviogram\InfluxDB\Collection\Value',
                true,
                'Aviogram\InfluxDB\Collection\Values'
            )->setCatchAllSetter('offsetSet');
        }

        $seriesConfig->addField('name', 'getName', 'setName');
        $seriesConfig->addField('values', 'getValues', 'setValues', $valuesConfig);
        $seriesConfig->addField('tags', 'getTags', 'setTags', $tagsConfig);

        // Main QueryResult entity
        $config = ByConfig::getConfigBuilder(
            'Aviogram\InfluxDB\Entity\Result',
            true,
            'Aviogram\InfluxDB\Collection\Result'
        );

        // Add include
        $config->addField('series', 'getSeries', 'setSeries', $seriesConfig);

        // Set error field
        $config->addField('error', 'getError', 'setError');

        return $config;
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->logger;
    }
}

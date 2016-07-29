<?php
namespace IMT\BehatProfilingExtension\Listener;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Behat\Behat\EventDispatcher\Event\StepTested;
use Behat\Behat\EventDispatcher\Event\BeforeStepTested;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class StopwatchListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $eventHash;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var Stopwatch
     */
    private $stopwatch;

    /**
     * @param Stopwatch $stopwatch
     * @param OutputInterface $output
     */
    public function __construct(Stopwatch $stopwatch, OutputInterface $output)
    {
        $this->stopwatch = $stopwatch;
        $this->output    = $output;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            StepTested::BEFORE => 'beforeStep',
            StepTested::AFTER  => 'afterStep',
        );
    }

    /**
     * @param BeforeStepTested $event
     */
    public function beforeStep(BeforeStepTested $event)
    {
        $this->eventHash = spl_object_hash($event);

        $this->stopwatch->start($this->eventHash, 'Step profiling');
    }

    public function afterStep()
    {
        $stopwatchEvent = $this->stopwatch->stop($this->eventHash);

        $this->output->writeln($stopwatchEvent->__toString());
    }
}

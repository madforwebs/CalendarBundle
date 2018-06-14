<?php
/*
 * This file is part of the MadForWebs package
 *
 * Copyright (c) 2018 Fernando Sánchez Martínez
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Fernando Sánchez Martínez <fer@madforwebs.com>
 */

namespace MadForWebs\CalendarBundle\Service;

use MadForWebs\CalendarBundle\Entity\Day;
use Symfony\Component\Validator\Constraints\DateTime;

class CalendarHandler
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    private $urlApiCalendar;
    public function __construct( $entityManager, $url )
    {
        $this->em = $entityManager;
        $this->urlApiCalendar = $url;
        return $this;
    }

    public function readCalendarMadrid()
    {
        $ignoreLines = [0];

        $file = fopen($this->urlApiCalendar, "r") or exit("Unable to open file!");
        $events = array();
        $countLine = 0;
        while(!feof($file))
        {
            $line = fgets($file);
            if(!in_array($countLine, $ignoreLines)){
                $line = str_replace("\r", "", $line );
                $line = str_replace("\n", "", $line);
                $linewArray = explode("\t", $line);

                if(
                (strpos($linewArray[3], 'festivo') !== false)||
                (strpos($linewArray[2], 'festivo') !== false)
                )
                {
                    $event = array();
                    $datetime = new DateTime();
                    $datetime = \DateTime::createFromFormat('d/m/Y', $linewArray[0]);
                    $event['date'] = $datetime;
                    if(isset($linewArray[4])){
                        $event['description'] = utf8_encode($linewArray[4]);
                    }else{
                        $event['description'] = "";
                    }
                    if (isset($linewArray[3])){
                        $event['name'] = $linewArray[3];
                    }else{
                        $event['name'] = $linewArray[2];
                    }

                    if($event['date']->format('Y') >= date("Y")){
                        $event['date'] = $event['date']->format('Y-m-d');
                        $events[] = $event;
                    }
                }
            }

            $countLine++;
        }
        fclose($file);
        return $events;
        return json_encode($events);
    }

    public function createDaysFromCalendar()
    {
        $events = $this->readCalendarMadrid();
        foreach ($events as $event) {

            $holiday = new Day();
            $holiday->setDescription($event['description']);
            $holiday->setDay(new \DateTime($event['date']));
            $holiday->setTitle($event['name']);
            $this->em->persist( $holiday);
        }
        $this->em->flush();
    }
}
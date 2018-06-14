https://datos.madrid.es/egobfiles/MANUAL/300082/calendario_2017.txt


<?
$file = fopen("1.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
{
echo fgets($file). "<br />";
}
fclose($file);
?>




        $response = new JsonResponse(array('response' => 'ok'));
        $em = $this->getDoctrine()->getManager();
        $events = require __DIR__.'/../data/calendar_item.php';
        foreach ($events as $event) {

            $holiday = new PublicHoliday();
            $holiday->setDescription($event['description']);
            $holiday->setDay(new \DateTime($event['date']));
            $holiday->setTitle($event['name']);

            $em->persist( $holiday);

        }

        $em->flush();

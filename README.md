CalendarBundle
=============

The `CalendarBundle` means easy-to-implement and feature-rich calendar in your Symfony application!

## Installation

### Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require madforwebs/calendar-bundle
```
This command requires you to have Composer installed globally, as explained
in the `installation chapter` of the Composer documentation.

### Enable the Bundle


Then, enable the bundle by adding the following line in the ``app/AppKernel.php``
file of your project:

```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new MadForWebs\CalendarBundle\CalendarBundle(),
        );

        // ...
    }

    // ...
}
```
    
## Import service calendar to app    

You must define import service from @CalendarBundle like this in your config.yml

```yml
    imports:
        ...
        - { resource: "@CalendarBundle/Resources/config/services.yml" }
        ...
```   
 
## Import calendar festive days    

An example use service to import festive days

```php
    /** @var CalendarHandler $calendarHandler */
    $calendarHandler = $this->get('mad_for_webs_calendar.handler');
    $calendarHandler->createDaysFromCalendar();
```

 
## Extend class day calendar    

You can extend class

```php
    use MadForWebs\CalendarBundle\Entity\Day as BaseDay;
    
    /**
     * @ORM\Entity
     * @ORM\Table(name="mfw_day")
     */
    class Day extends BaseDay
    {
        ...
    }
```


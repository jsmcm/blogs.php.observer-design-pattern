<?php


interface SubjectInterface
{

    public function subscribe($object);
    public function unsubscribe($object);
    public function notify();

}

class Subject implements SubjectInterface
{
    private $observers = [];

    public function subscribe($object)
    {

        print "Checking if ".$object->name." is already an observer?\r\n";

        if ( ! in_array($object, $this->observers)) {
            print "its not, subscribing it now.\r\n";
            $this->observers[] = $object;
        } else {
            print "it is already\r\n";
        }

    }

    public function unsubscribe($object)
    {

        $index = array_search($object, $this->observers);
        
        if ($index !== false) {
            array_splice($this->observers, $index, 1);
        }
    }

    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }

    // OTHER METHODS HERE...

}



interface ObserverInterface
{
    public function update();
}

class ObserverOne implements ObserverInterface 
{
    public $name = "ObserverOne";

    public function update() {
        print "\r\nupdate called in ObserverOne\r\n";
    }

    // OTHER METHODS HERE...
    
}

class ObserverTwo implements ObserverInterface
{
    public $name = "ObserverTwo";
    
    public function update() {
        print "\r\nupdate called in ObserverTwo\r\n";
    }

    // OTHER METHODS HERE...
    
}




$ObserverOne = new ObserverOne();
$ObserverTwo = new ObserverTwo();

$subject = new Subject();


print "\r\n------\r\n";
print "Attempt to subscribe ObserverOne as an observer with subscribe\r\n";
usleep(100);
$subject->subscribe($ObserverOne);


print "Attempt to subscribe ObserverOne a second time as an observer with subscribe\r\n";
usleep(100);
$subject->subscribe($ObserverOne);




print "\r\n------\r\n";
print "Attempt to subscribe ObserverTwo as an observer with subscribe\r\n";
usleep(100);
$subject->subscribe($ObserverTwo);


sleep(3);

print "after sleep\r\n";
print "Calling notify on subject (with two subscribe observers)...\r\n";
usleep(100);
$subject->notify();


print "\r\n------\r\n";
print "Unregister ObserverOne as an observer with register\r\n";
usleep(100);
$subject->unsubscribe($ObserverOne);


sleep(3);

print "after sleep\r\n";
print "Calling notify on subject (with one registered observer)...\r\n";
usleep(100);
$subject->notify();




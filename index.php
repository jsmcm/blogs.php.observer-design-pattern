<?php


interface SubjectInterface
{

    public function register($object);
    public function unregister($object);
    public function notify();

}

class Subject implements SubjectInterface
{
    private $observers = [];

    public function register($object)
    {

        print "Checking if ".$object->name." is already an observer?\r\n";

        if ( ! in_array($object, $this->observers)) {
            print "its not, registering it now.\r\n";
            $this->observers[] = $object;
        } else {
            print "it is already\r\n";
        }

    }

    public function unregister($object)
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


    /**
     * Below is the "actual" functionality of this class.
     */

    /**
     * We're mocking state change by calling this function from the outside.
     * In real life this would be non trivial as it is in this example.
     */
    public function updateState()
    {
        // Do whatever stuff where, then notify our observers

        // more code here

        $this->notify();
    }

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
}

class ObserverTwo implements ObserverInterface
{
    public $name = "ObserverTwo";
    
    public function update() {
        print "\r\nupdate called in ObserverTwo\r\n";
    }
}




$ObserverOne = new ObserverOne();
$ObserverTwo = new ObserverTwo();

$subject = new Subject();


print "\r\n------\r\n";
print "Attempt to register ObserverOne as an observer with register\r\n";
usleep(100);
$subject->register($ObserverOne);


print "Attempt to register ObserverOne a second time as an observer with register\r\n";
usleep(100);
$subject->register($ObserverOne);




print "\r\n------\r\n";
print "Attempt to register ObserverTwo as an observer with register\r\n";
usleep(100);
$subject->register($ObserverTwo);


sleep(3);

print "after sleep\r\n";
print "Calling updateState on subject (with two registered observers)...\r\n";
usleep(100);
$subject->updateState();


print "\r\n------\r\n";
print "Unregister ObserverOne as an observer with register\r\n";
usleep(100);
$subject->unregister($ObserverOne);


sleep(3);

print "after sleep\r\n";
print "Calling updateState on subject (with one registered observer)...\r\n";
usleep(100);
$subject->updateState();




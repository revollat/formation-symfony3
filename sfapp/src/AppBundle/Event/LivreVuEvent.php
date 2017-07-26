<?
namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Livre;

class LivreVuEvent extends Event
{
    const NAME = 'app.livre.vu';

    protected $livre;

    public function __construct(Livre $livre)
    {
        $this->livre = $livre;
    }

    public function getLivre()
    {
        return $this->livre;
    }
}

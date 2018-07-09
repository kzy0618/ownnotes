<?php
namespace OCA\OwnNotes\AppInfo;
use OCA\OwnNotes\Db\NoteMapper;
use \OCP\AppFramework\App;
use \OCA\OwnNotes\Controller\PageController;
use \OCA\OwnNotes\Service\NoteService;
use OCP\AppFramework\IAppContainer;
class Application extends App {
    public function __construct(array $urlParams=array()){
        parent::__construct('ownnotes', $urlParams);
        $container = $this->getContainer();
		/**
		 * Controllers and Services
		 */
        $container->registerService('PageController', function(IAppContainer $c) {
            return new PageController(
                $c->query('AppName'),
                $c->query('Request')
            );
        });
		$container->registerService('NoteService', function(IAppContainer $c) {
			return new NoteService(
				$c->query('Logger'),
				$c->query('AppName')
			);
		});
		$container->registerService('NoteMapper', function(IAppContainer $c) {
			return new NoteMapper(
				$c->query('Logger'),
				$c->query('AppName')
			);
		});
		$container->registerService('Logger', function(IAppContainer $c) {
			return $c->query('ServerContainer')->getLogger();
		});
    }
}

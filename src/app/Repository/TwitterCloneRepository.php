<?php
// app/src/Repository/TwitterCloneRepository.php
namespace App\Repository;

use DateTime;
use Monolog\Logger;
use PDO;

/**
 * Class that encapsulates the retrieval of tweets from the table 'tweet' and
 * and the insertion of a tweet into the table 'tweet'. Uses PDO and 
 * assumes MySQL database.
 *
 * @author Robert C. McIntosh <rcmcintosh0214@gmail.com>
 */
final class TwitterCloneRepository
{
    /**
     * @var PDO 
     */
    private $pdo;

    /**
     * @var Silex\Provider\MonologServiceProvider
     */
    private $logger;
    
    /**
     * Class constructor
     *
     * <code>
     * $config = array(
     *     'db_host' => 'DB_HOST',  // host
     *     'db_name' => 'DB_NAME',  // name of database
     *     'db_user' => 'username', // db user name
     *     'db_pass' => 'userpass'  // password for db user
     * );
     * </code>
     *
     * @param array $config
     * @param Logger $logger
     */    
    public function __construct(array $config, Logger $logger)
    {
        $this->logger = $logger;
        
        $conn = "mysql:host=" . $config['db_host'] . ";dbname=" . $config['db_name'] . ";charset=utf8";
        
        try {
            $this->pdo = new PDO($conn, $config['db_user'], $config['db_pass'], array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
        } catch (Exception $e) {
            $this->logger->addError(sprintf("Error: '%s'", $e->getMessage())); 
        }
    }

    /**
     * Returns all Tweets, ordered by most recent first.
     *
     * On query failure, returns empty array. On query success,
     * returns array containing results of query.
     *
     * @return array
     */    
    public function findAllByMostRecent()
    {
        $rows = array();
        
        try {
            /** @vars $stmt PDOStatement on success, FALSE on failure */
            $stmt = $this->pdo->query("SELECT text, created FROM tweet ORDER BY created DESC");
            
            if (!$stmt) {
                return $rows;
            }
            
            /** @vars $rows array */
            $rows = $stmt->fetchAll(PDO::FETCH_NUM);
        } catch (PDOException $e) {
            $this->logger->addInfo(sprintf("Error: '%s'", $e->getMessage()));
        }
        
        $this->pdo = null;

        return $rows;
    }
    
    /**
     * Insert Tweet into tweet table.
     *
     * On insertion failure, returns false. On insertion success,
     * returns number of rows affected.
     *
     * @param string $tweet
     * 
     * @return
     */
    public function addTweet($tweet)
    {
        $result = false;
        
        try {
            $insert = "INSERT INTO tweet(text,created) VALUES (:text,:created)";
            /** @vars $stmt PDOStatement on success, PDOException on failure */
            $stmt = $this->pdo->prepare($insert);

            $created = new \DateTime('NOW');
        
            $temp = array(
                ':text'    => $tweet,
                ':created' => $created->format('Y-m-d H:i:s')
            );
            
            /** @vars $result Number of rows affected */
            $result = $stmt->execute($temp);
        } catch (PDOException $e) {
            $this->logger->addError(sprintf("Error: '%s'", $e->getMessage()));        
        }
        
        $this->pdo = null;

        return $result;
    }
}

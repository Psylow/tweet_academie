<?php
include('connexionbdd.class.php');
class login 
{
    protected $connexion;
    protected $bdd;
    private $mail;
    private $motDePass;

    public function __construct($newMail, $newMDP)
    {
        $this->mail = $newMail;
        $this->motDePass = hash_hmac('ripemd160', $newMDP, 'vive le projet tweet_academy');
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function checkAccount()
    {
        $query = $this->bdd->prepare('select password from users where mail = ?');
        $query->execute(array($this->mail));
        while ($result = $query->fetch()) {
            if ($result['password'] == $this->motDePass) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getInfo()
    {
        $info = $this->bdd->prepare('select * from users INNER join user_info where users.id = user_info.id_user && mail =?');
        $info->execute(array($this->mail));
        return $info->fetch();
    }

    public function addTweet($tweet)
    {
        $info = $this->getInfo();

        $tableauMotTweet = explode(" ", $tweet);
        $newTweet = [];
        $listHashtag = "";
        foreach ($tableauMotTweet as $value) {
            if ($value[0] == "#") {
                $listHashtag .= $value . ',';
                $value = "<a href='search.php?search=" . substr($value, 1) . "&type=Tweet'>" . $value . "</a>";
            }
            if ($value[0] == "@") {
                $value = "<a href='membre.php?pseudo=" . substr($value, 1) . "'>" . $value . "</a>";
            }
            array_push($newTweet, $value);
        }
        $newTweet = implode(" ", $newTweet);

        if ($listHashtag == "") {
            $insert = $this->bdd->prepare('insert into post (id_user,post_content,post_date) VALUES (?,?,?)');
            $insert->execute(array(
                $info['id'],
                $newTweet,
                date("Y-m-d H:i:s")
            ));
        } else {
            $insert = $this->bdd->prepare('insert into post (id_user,post_content,post_date,hashtags) VALUES (?,?,?,?)');
            $insert->execute(array(
                $info['id'],
                $newTweet,
                date("Y-m-d H:i:s"),
                $listHashtag
            ));
        }
    }

    public function basicQuery($newQuery)
    {
        return $this->bdd->query($newQuery);
    }

    public function error($msg)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show">
        <strong>Error!</strong>' . $msg . '</div>';
    }

    public function valide($confirm)
    {
        echo '<div class="alert alert-success" role="alert">
        <strong>Félicitation</strong> ' . $confirm . '.
      </div>';
    }
}

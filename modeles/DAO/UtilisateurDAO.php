<?php

namespace SIOC\modeles\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\DBAL\Connection;

use SIOC\modeles\donnees\Utilisateur;

/**
 * Description of ActiviteDAO
 *
 * @author Remi Lelaidier
 */
class UtilisateurDAO extends DAO implements UserProviderInterface
{
    /**
     * Returns a user matching the supplied id.
     *
     * @param integer $id The user id.
     *
     * @return \MicroCMS\Domain\User|throws an exception if no matching user is found
     */
    public function find($id) {
        $sql = "SELECT * FROM Utilisateurs WHERE uti_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Aucun utilisateur avec l'id " . $id);
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "SELECT * FROM Utilisateurs WHERE uti_username=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('Utilisateur "%s" non trouve.', $username));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'SIOC\modeles\donnees' === $class;
    }

    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \MicroCMS\Domain\User
     */
    protected function buildDomainObject($row) {
        $user = new Utilisateur();
        $user->setId($row['uti_id']);
        $user->setMail($row['uti_mail']);
        $user->setUsername($row['uti_username']);
        $user->setNom($row['uti_nom']);
        $user->setPrenom($row['uti_prenom']);
        $user->setPassword($row['uti_password']);
        $user->setSalt($row['uti_salt']);
        $user->setRole($row['uti_role']);
        return $user;
    }
}

<?php

namespace SIOC\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use SIOC\donnees\Utilisateur;

/**
 * Description of UtilisateurDAO
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
     * @return \SIOC\modeles\donnees\Utilisateur
     */
    public function find($id) {
        $sql = "SELECT * FROM Utilisateur WHERE uti_id";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
        {
            return $this->buildDomainObject($row);
        }
    }
    
    /*
     * Renvoie l'utilisateur associe a l'activite[id]
     * 
     * 
     * @param integer $id l'id de l'activite
     *
     * @return \SIOC\modeles\donnees\Utilisateur
     * 
     * */
    public function findbyActivite($id)
    {
        $sql = "SELECT U.uti_id, U.uti_mail, U.uti_username, U.uti_nom,"
                . " U.uti_prenom, U.uti_password, U.uti_salt, U.uti_role"
                . " FROM Utilisateur AS U, Activite AS A"
                . " WHERE U.uti_id = A.act_eleve"
                . " AND A.act_id = ?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if($row)
        {
            return $this->buildDomainObject($row);
        }
    }
    
    public function findbyPromotion($id)
    {
        $sql = "SELECT U.uti_id, U.uti_mail, U.uti_username, U.uti_nom,"
                . " U.uti_prenom, U.uti_password, U.uti_salt, U.uti_role"
                . " FROM Utilisateur AS U, Faitpartie AS F"
                . " WHERE U.uti_id = F.fap_eleve"
                . " AND F.fap_promo = ?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if($row)
        {
            return $this->buildDomainObject($row);
        }
    }
    
    public function findAllEleve()
    {
        //TODO
    }

    public function findAllProfesseur()
    {
        //TODO
    }
    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "SELECT * FROM Utilisateurs WHERE uti_username=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)
        {
            return $this->buildDomainObject($row);
        }
        else
        {
            throw new UsernameNotFoundException(sprintf('Utilisateur "%s" non trouve.', $username));
        }
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
     * @return \SIOC\modeles\donnees\Utilisateur
     */
    protected function buildDomainObject($row) {
        $user = new Utilisateur();
        $user->hydrate($row);
        return $user;
    }
}

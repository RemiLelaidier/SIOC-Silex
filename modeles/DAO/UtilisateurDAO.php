<?php

namespace SIOC\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use SIOC\donnees\Utilisateur;
use SIOC\donnees\Promotion;

use SIOC\DAO\PromotionDAO;
use SIOC\DAO\CursusDAO;

/**
 * Description of UtilisateurDAO
 *
 * @author Remi Lelaidier
 */
class UtilisateurDAO extends DAO implements UserProviderInterface
{
    /**
     * Retourne l'Utilisateur avec l'id correspondante
     *
     * @param integer $id
     * @return \SIOC\modeles\donnees\Utilisateur
     */
    public function find($id) {
        $sql = "SELECT * FROM Utilisateur WHERE uti_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
        {
            if($row['uti_role'] == 'ROLE_ELEVE')
            {
                $promotion = new PromotionDAO($this->getDb());
                $cursus = new CursusDAO($this->getDb());
                $row['uti_promotion'] = $promotion->findByEleve($row['uti_id']);
                $row['uti_cursus'] = $cursus->findByEleve($row['uti_id']);
            }
            return $this->buildDomainObject($row);
        }
    }
    
    /**
     * Retourne tous les utilisateurs
     *
     * @param none
     * @return array(\SIOC\donnees\Utilisateur)
     * 
     * TODO : Cursus et Promotion
     */
    public function findAll()
    {
        $sql = "SELECT * FROM Utilisateur";
        $result = $this->getDb()->fetchAll($sql);
        $utilisateurs = array();
        foreach($result as $row)
        {
            $utilisateurId = $row['uti_id'];
            if($row['uti_role'] == 'ROLE_ELEVE')
            {
                $promotion = new PromotionDAO($this->getDb());
                $cursus = new CursusDAO($this->getDb());
                $row['uti_promotion'] = $promotion->findByEleve($utilisateurId);
                $row['uti_cursus'] = $cursus->findByEleve($utilisateurId);
            }
            $utilisateurs[$utilisateurId] = $this->buildDomainObject($row);
        }
        return $utilisateurs;
    }
    
    /**
     * Trouve l'utilisateur associe a l'activite
     *
     * @param integer $id
     * @return \SIOC\donnees\Utilisateur
     * 
     * TODO : Cursus et Promotion
     */
    public function findbyActivite($id)
    {
        $sql = "SELECT U.uti_id, U.uti_mail, U.uti_username, U.uti_nom,"
                . " U.uti_prenom, U.uti_password, U.uti_salt, U.uti_role"
                . " FROM Utilisateur AS U, Activite AS A"
                . " WHERE U.uti_id = A.act_eleve"
                . " AND A.act_id = ?";
        $row = $this->getDb()->fetchAll($sql, array($id));
        if($row)
        {
            if($row['uti_role'] == 'ROLE_ELEVE')
            {
                $promotion = new PromotionDAO($this->getDb());
                $cursus = new CursusDAO($this->getDb());
                $row['uti_promotion'] = $promotion->findByEleve($row['uti_id']);
                $row['uti_cursus'] = $cursus->findByEleve($row['uti_id']);
            }
            return $this->buildDomainObject($row);
        }
    }
    
    /**
     * Trouve les utilisateurs associes a une promotion
     *
     * @param integer $id
     * @return array(\SIOC\donnees\Utilisateur)
     * 
     * TODO : Cursus et Promotion
     */
    public function findAllbyPromotion($id)
    {
        $sql = "SELECT U.uti_id, U.uti_mail, U.uti_username, U.uti_nom,"
                . " U.uti_prenom, U.uti_password, U.uti_salt, U.uti_role"
                . " FROM Utilisateur AS U, Faitpartie AS F"
                . " WHERE U.uti_id = F.fap_eleve"
                . " AND F.fap_promo = ?";
        $result = $this->getDb()->fetchAll($sql, array($id));
        $eleves = array();
        foreach($result as $row)
        {
            $eleveId = $row['uti_id'];
            $promotion = new PromotionDAO($this->getDb());
            $cursus = new CursusDAO($this->getDb());
            $row['uti_promotion'] = $promotion->findByEleve($eleveId);
            $row['uti_cursus'] = $cursus->findByEleve($eleveId);
            $eleves[$eleveId] = $this->buildDomainObject($row);
        }
        return $eleves;
    }
    
    /**
     * Trouve les utilisateurs qui sont des eleves
     *
     * @param none
     * @return array(\SIOC\donnees\Utilisateur)
     * 
     * TODO : Cursus et Promotion
     */
    public function findAllEleve()
    {
        $sql = "SELECT * FROM Utilisateur"
                . " WHERE uti_role = 'ROLE_ELEVE'";
        $result = $this->getDb()->fetchAll($sql);
        $eleves = array();
        foreach($result as $row)
        {
            $eleveId = $row['uti_id'];
            $promotion = new PromotionDAO($this->getDb());
            $cursus = new CursusDAO($this->getDb());
            $row['uti_promotion'] = $promotion->findByEleve($eleveId);
            $row['uti_cursus'] = $cursus->findByEleve($eleveId);
            $eleves[$eleveId] = $this->buildDomainObject($row);
        }
        return $eleves;
    }

    /**
     * Trouve les utilisateurs qui sont des professeurs
     *
     * @param none
     * @return array(\SIOC\donnees\Utilisateur)
     */
    public function findAllProfesseur()
    {
        $sql = "SELECT * FROM Utilisateur"
                . " WHERE uti_role = 'ROLE_PROF'";
        $result = $this->getDb()->fetchAll($sql);
        $professeurs = array();
        foreach($result as $row)
        {
            $professeurId = $row['uti_id'];
            $professeurs[$professeurId] = $this->buildDomainObject($row);
        }
        return $professeurs;
    }
    
    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "SELECT * FROM Utilisateur WHERE uti_username=?";
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
        return 'SIOC\donnees\Utilisateur' === $class;
    }

    /**
     * Cree un Utilisateur avec un tuple.
     *
     * @param array $row 
     * @return \SIOC\donnees\Utilisateur
     */
    protected function buildDomainObject($row) {
        $user = new Utilisateur();
        $user->hydrate($row);
        return $user;
    }
    
    /**
     * Sauvegarde/MAJ d'un Utilisateur
     *
     * @params \SIOC\donnees\Utilisateur
     *         \SIOC\donnees\Promotion
     * @return none
     * 
     * TODO : SAUVEGARDE CURSUS
     */
    public function save(Utilisateur $utilisateur, Promotion $promotion, Cursus $cursus) {
        $utilisateurData = array(
            'uti_username'  => $utilisateur->getUsername(),
            'uti_nom'       => $utilisateur->getNom(),
            'uti_prenom'    => $utilisateur->getPrenom(),
            'uti_mail'      => $utilisateur->getMail(),
            'uti_password'  => $utilisateur->getPassword(),
            'uti_salt'      => $utilisateur->getSalt(),
            'uti_role'      => $utilisateur->getRole()
        );
        
        if ($utilisateur->getId()){
            $this->getDb()->update('Utilisateur', $utilisateurData, array('uti_id' => $utilisateur->getId()));
            if( $utilisateur->getRole() == 'ROLE_ELEVE')
            {
                $this->getDb()->delete('Faitpartie', array(
                    'fap_eleve'  => $utilisateur->getId()
                ));
                $promotionData = array(
                    'fap_eleve'     => $utilisateur->getId(),
                    'fap_promo'     => $promotion->getId()
                );
                $this->getDb()->insert('Faitpartie', $promotionData);
                
                $this->getDb()->delete('Suit', array(
                    'sui_eleve'     => $utilisateur->getId()
                ));
                $cursusData = array(
                    'sui_eleve'     => $utilisateur->getId(),
                    'sui_cursus'    => $cursus->getId()
                );
                $this->getDb()->insert('Suit', $cursusData);
            }
        }
        else {
            $this->getDb()->insert('Utilisateur', $utilisateurData);
            $id = $this->getDb()->lastInsertId();
            $utilisateur->setId($id);
            if( $utilisateur->getRole() == 'ROLE_ELEVE')
            {
                $promotionData = array(
                    'fap_eleve'     => $utilisateur->getId(),
                    'fap_promo'     => $promotion->getId()
                );
                $this->getDb()->insert('Faitpartie', $promotionData);
                
                $cursusData = array(
                    'sui_eleve'     => $utilisateur->getId(),
                    'sui_cursus'    => $cursus->getId()
                );
                $this->getDb()->insert('Suit', $cursusData);
            }
        }
    }
    
    /**
     * Suppression de l'Utilisateur
     *
     * @params \SIOC\donnees\Utilisateur $utilisateur
     * @return none
     */
    public function erase($utilisateur)
    {
        $this->getDb()->delete('Utilisateur', array(
            'uti_id'  => $utilisateur->getId()
        ));
    }
}

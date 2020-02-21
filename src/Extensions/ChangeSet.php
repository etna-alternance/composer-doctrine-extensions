<?php

namespace ETNA\Doctrine\Extensions;

/**
 * Ce trait permet de maintenir le change set pour une entité
 */
trait ChangeSet
{
    public $change_set = [];

    /**
     * Set the value of change_set
     *
     * @param array   $change_set   the change set
     *
     * @return self
     */
    public function setChangeSet(array $change_set)
    {
        // On ajoute les tags changés au change_set s'ils avaient été ajouté
        if (false === empty($this->getChangeSet()["added_tags"])) {
            $change_set["added_tags"] = $this->getChangeSet()["added_tags"];
        }

        if (false === empty($this->getChangeSet()["deleted_tags"])) {
            $change_set["deleted_tags"] = $this->getChangeSet()["deleted_tags"];
        }

        $this->change_set = $change_set;

        return $this;
    }

    /**
     * Ajoute un champ au change_set de l'entité si elle possède cette propriété
     *
     * @param string         $field_name   le nom du champ
     * @param array          $data         les données changées
     *
     * @return null
     */
    public function addFieldToChangeSet($field_name, array $data)
    {
        $this->change_set[$field_name] = $data;
    }

    /**
     * Get the value of change_set
     *
     * @return array|null
     */
    public function getChangeSet()
    {
        return $this->change_set;
    }
}

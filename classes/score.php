<?php

class Score
{

    /**
     *
     * The id of the doctor.
     * 
     * @var int <p>Id.</p>
     */
    private $id = 0;
    /**
     *
     * The doctor.
     * 
     * @var object <p>Doctor object.</p>
     */
    private $score;

    /**
     *
     * @param type $i <p>Id of the doctor.</p>
     */
    public function __construct($i = 0)
    {
        $sql = new Database();
        $this->id = intval($i);
        $this->score = $sql->doQueryArray("SELECT * FROM `pre_opscore` WHERE `id` = '" . ($this->id) . "'");
    }

    public function GetId()
    {
        return $this->score['id'] ? $this->score['id'] : "&nbsp;";
    }

    /**
     *
     * We are getting the date of the score.
     * 
     * @return int <p>Date.</p>
     */
    public function GetDate()
    {
        return $this->score['dateof'] ? $this->score['dateof'] : 0;
    }

    public function GetPhysicalFunctioning()
    {
        return $this->score['pfunctioning'] ? $this->score['pfunctioning'] : "&nbsp;";
    }

    public function GetRolePhysical()
    {
        return $this->score['rphysical'] ? $this->score['rphysical'] : "&nbsp;";
    }

    public function GetBodilyPain()
    {
        return $this->score['bpain'] ? $this->score['bpain'] : "&nbsp;";
    }

    public function GetGeneralHealth()
    {
        return $this->score['ghealth'] ? $this->score['ghealth'] : "&nbsp;";
    }

    public function GetVitality()
    {
        return $this->score['vitality'] ? $this->score['vitality'] : "&nbsp;";
    }

    public function GetSocialFunctioning()
    {
        return $this->score['sfunctioning'] ? $this->score['sfunctioning'] : "&nbsp;";
    }

    public function GetRoleEmotional()
    {
        return $this->score['remotional'] ? $this->score['remotional'] : "&nbsp;";
    }

    public function GetMentalHealth()
    {
        return $this->score['mhealth'] ? $this->score['mhealth'] : "&nbsp;";
    }

}

?>
<div class="res-content container-fluid">
  <?php if(isset($_POST) && isset($_POST["adr"])) {
    $adr=new APIAdr($_POST);
    $adr->fetchAdr();
    $allAdr=$adr->getRes();
    $nbrRes=isset($allAdr->features) ? sizeof($allAdr->features) : 0;

    if(isset($allAdr->features) && $nbrRes>0) { ?>
      <h1> Résultats pour "<?php echo $allAdr->query ?>" </h1>
      <table class="table  container-fluid">
        <thead>
          <tr class="tr">
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>X</th>
            <th>Y</th>
            <th>% Sûr</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach($allAdr->features as $key=>$res) {
              $singleRes=$res->properties;
              ?>
              <tr>
                <td><?php echo $singleRes->name ?></td>
                <td><?php echo $singleRes->citycode ?></td>
                <td><?php echo $singleRes->city ?></td>
                <td><?php echo $singleRes->x ?></td>
                <td><?php echo $singleRes->y ?></td>
                <td><?php echo round((float)$singleRes->score*100,2) ?></td>
              </tr>
            <?php } ?>
        </tbody>
      </table>
      
    <?php 
      echo $nbrRes." résultat".($nbrRes>1 ? "s" : "" );
    } else { ?>
      <div class="alert alert-danger">
        <h4>Aucune donnée ne correspond aux filtres suivants: </h4>
        <span>Adresse: "<?php echo isset($_POST["adr"]) ? $_POST["adr"] : "Non renseignée" ?>"</span> <br/>
        <span>Code postal: "<?php echo isset($_POST["cp"]) ? $_POST["cp"] : "Non renseigné" ?>"</span> <br/>
        <span>Ville: "<?php echo isset($_POST["city"]) ? $_POST["city"] : "Non renseignée" ?>"</span> <br/>
    </div>
    <?php } ?>
    
  <?php } else { ?>
    <div class="alert alert-danger">
      <h4>Aucune donnée ne correspond aux filtres suivants: </h4>
      <span>Adresse: "<?php echo isset($_POST["adr"]) ? $_POST["adr"] : "Non renseignée" ?>"</span> <br/>
      <span>Code postal: "<?php echo isset($_POST["cp"]) ? $_POST["cp"] : "Non renseigné" ?>"</span> <br/>
      <span>Ville: "<?php echo isset($_POST["city"]) ? $_POST["city"] : "Non renseignée" ?>"</span> <br/>
    </div>
  <?php } ?>
</div>

<?php
class APIAdr {
  private stdClass $APIres;
  public string $adr;
  public int $cp;
  public string $ville;

  public string $APIAdr;

  function __construct(array $req) {
    $this->adr=$req['adr'];
    $this->cp=isset($req['cp']) ? (int)$req['cp'] : null;
    $this->ville=isset($req['city']) ? (string)$req['city'] : null;

    $this->APIAdr="https://api-adresse.data.gouv.fr/search/?q=".urlencode($this->adr)."&postcode=".$this->cp."&limit=10&autocomplete=1";
  }

  function fetchAdr(): void {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $this->APIAdr);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING , "");
    $this->APIres = json_decode(curl_exec($curl));
    curl_close($curl);
  }

  function getRes(): stdClass {
    return $this->APIres;
  }
}

?>
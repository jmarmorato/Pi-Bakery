<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">
    New Pi
  </h1>

  <form id="newPiForm" action="/endpoints/new_pi.php" method="post">

    <div id="accordion">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h5 class="mb-0">
            <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#piBasicInfo"
              aria-expanded="true" aria-controls="piBasicInfo">
              Basic Info
            </button>
          </h5>
        </div>
        <div id="piBasicInfo" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="piName">Name</label>
                  <input type="text" class="form-control" id="piName" aria-describedby="nameHelp"
                    placeholder="Calendar TV" name="piName">
                  <small id="nameHelp" class="form-text text-muted">Enter a name for the Pi. This is for administrative
                    purposes
                    and is not used by the system.</small>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="piSerial">Serial Number</label>
                  <input type="text" class="form-control" id="piSerial" aria-describedby="serialHelp"
                    placeholder="c5cfff1d" name="piSerial">
                  <small id="serialHelp" class="form-text text-muted">Enter the serial number of the Pi here, omitting
                    the
                    leading "10000000".</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#bootNetConfig"
              aria-expanded="false" aria-controls="bootNetConfig">
              Netboot Network Configuration
            </button>
          </h5>
        </div>
        <div id="bootNetConfig" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="piName">Netboot Network Configuration</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="piBootNetworkRadios" id="networkRadio1"
                      value="dhcp" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      DHCP
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="piBootNetworkRadios" id="networkRadio2"
                      value="static">
                    <label class="form-check-label" for="exampleRadios2">
                      Static
                    </label>
                  </div>
                  <small id="nameHelp" class="form-text text-muted">Choose whether the Pi will be configured manually or
                    with
                    DHCP.</small>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="piCidr">IP Address in CIDR Notation</label>
                  <input type="text" class="form-control" id="piBootCidr" aria-describedby="cidrHelp"
                    placeholder="192.168.0.74/24" name="piBootCidr">
                  <small id="cidrHelp" class="form-text text-muted">Enter the IP address and netmask for netbooting.
                    Ensure the host address is not in the DHCP scope for the subnet to prevent address
                    collisions.</small>
                </div>
                <div class="form-group">
                  <label for="piGateway">Default Gateway</label>
                  <input type="text" class="form-control" id="piBootGateway" aria-describedby="gatewayHelp"
                    placeholder="192.168.0.1" name="piBootGateway">
                  <small id="gatewayHelp" class="form-text text-muted">Enter the default gateway for
                    netbooting..</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#osNetConfig"
              aria-expanded="false" aria-controls="osNetConfig">
              OS Network Configuration
            </button>
          </h5>
        </div>
        <div id="osNetConfig" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="piName">OS Network Configuration</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="piOSNetworkRadios" id="piOSNetworkRadios1"
                      value="dhcp" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      DHCP
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="piOSNetworkRadios" id="piOSNetworkRadios2"
                      value="static">
                    <label class="form-check-label" for="exampleRadios2">
                      Static
                    </label>
                  </div>
                  <small id="nameHelp" class="form-text text-muted">Choose whether the Pi will be configured manually or
                    with
                    DHCP.</small>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="piCidr">IP Address in CIDR Notation</label>
                  <input type="text" class="form-control" id="piOSCidr" aria-describedby="cidrHelp"
                    placeholder="192.168.0.74/24" name="piOSCidr">
                  <small id="cidrHelp" class="form-text text-muted">Enter the IP address and netmask for netbooting.
                    Ensure the host address is not in the DHCP scope for the subnet to prevent address
                    collisions.</small>
                </div>
                <div class="form-group">
                  <label for="piGateway">Default Gateway</label>
                  <input type="text" class="form-control" id="piOSGateway" aria-describedby="gatewayHelp"
                    placeholder="192.168.0.1" name="piOSGateway">
                  <small id="gatewayHelp" class="form-text text-muted">Enter the default gateway for
                    netbooting..</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <h5 class="mb-0">
            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#templateConfig"
              aria-expanded="false" aria-controls="templateConfig">
              Template Configuration
            </button>
          </h5>
        </div>
        <div id="templateConfig" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
          <div class="card-body" id="template_param">

            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="piName">Template</label>
                  <select onchange="selectTemplate(this.value)" name="piTemplate" class="custom-select mr-sm-2" id="templateSelectDropdown">
                    <option selected disabled>Choose...</option>
                    <?php foreach ($data["templates"] as $template): ?>
                      <option value="<?php echo basename($template["template_name"]); ?>"><?php echo $template["template_name"]; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <small id="nameHelp" class="form-text text-muted">Chose the template to be deployed to the Pi.</small>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="piName">Image</label>
                  <select name="piImage" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                    <option selected disabled>Choose...</option>
                    <?php foreach ($data["images"] as $image): ?>
                      <option value="<?php echo basename($image); ?>"><?php echo basename($image); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <small id="nameHelp" class="form-text text-muted">Chose the image to be deployed to the Pi.</small>
                </div>
              </div>
            </div>

            <div id="template_param_container"></div>

          </div>
        </div>
      </div>
    </div>


    <input type="hidden" name="templateParams" id="templateParams" />
    <button type="button" onclick="submit_new_pi()" class="btn btn-primary mt-2">Submit</button>

  </form>

</div>
<!-- /.container-fluid -->
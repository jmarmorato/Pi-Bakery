<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">Pis</h1>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Status</th>
        <th scope="col">Serial</th>
        <th scope="col">Template</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($data["pis"] as $pi): ?>
        <tr>
          <th scope="row">
            <?php echo $pi["name"]; ?>
          </th>
          <td>Online</td>
          <td>
            <?php echo $pi["serial"]; ?>
          </td>
          <td>
            <?php echo $pi["template"]; ?>
          </td>
          <td>
            <button class="btn btn-warning mr-1">Edit</button>
            <button data-piid="<?php echo $pi["id"]; ?>" class="btn btn-danger mr-1 delete-pi-btn">Delete</button>
            <button data-piid="<?php echo $pi["id"]; ?>"
              class="btn btn-secondary mr-1 provision-pi-btn">Reprovision</button>
          </td>
        </tr>
      <?php endforeach; ?>

    </tbody>
  </table>

  <!-- Modal -->
  <div class="modal fade" id="confirmDeletePiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirm Delete Pi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this Pi? All Pi data will be lost.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a id="deletePiEndpoint"><button type="button" class="btn btn-danger">Delete</button></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="confirmProvision" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirm Provision</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to provision this device? If the device is already provisioned, it will be reset to
          defaults.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a id="provisionPiEndpoint"><button type="button" class="btn btn-warning">Provision</button></a>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
<div class="container">
    <div class="row">
        <div class="col-lg-5 col-md-15 mx-auto">
            <div class="alert alert-danger" role="alert" id="message-danger">
            </div>
            <div class="alert alert-success" role="alert" id="message-success">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-15 mx-auto" id="mainRow">

            <form action="/create" method="POST">


                <div id="name-group" class="form-group">
                    <label for="name">Прізвище Ім'я</label>
                    <input type="text" class="form-control" name="name" placeholder="ПІП">
                </div>


                <div id="email-group" class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" placeholder="example@gmail.com">
                </div>


                <div id="selectRegion-group" class="form-group">
                    <select id="selectRegion" name="selectRegion" class="chosen-select">
                        <option value="-1">Оберіть область</option>
                    </select>
                </div>


                <div id="selectCity-group" class="form-group">
                    <select id="selectCity" name="selectCity" class="chosen-select">
                    </select>
                </div>


                <div id="selectDistrict-group" class="form-group">
                    <select id="selectDistrict" name="selectDistrict" class="chosen-select">
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-sm">Зареєструвати</button>

            </form>

        </div>
    </div>
</div>


<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Користувача з таким email вже зареєстровано</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-role="delete"]').forEach(function(button) {
            var id = button.dataset.id
            button.addEventListener('click', function () {
                deleteProject(id)
            })
        })

        document.querySelector('#addContact').addEventListener('click', function(e) {
            e.preventDefault();
            var name = document.querySelector('#newName')
            var email = document.querySelector('#newEmail')
            var index = document.querySelectorAll('[data-contact]').length

            document.querySelector('#contacts').innerHTML += `
                <div data-contact>
                    <div class="form-group">
                        <label for="name">Név:</label>
                        <input type="text" name="contacts[${index}][name]" value="${name.value}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="contacts[${index}][email]" value="${email.value}">
                    </div>
                </div>
            `

            name.value = ''
            email.value = ''
        })
    });

    function deleteProject(id) {
        $.ajax({
            type: 'POST',
            url: '/delete.php',
            data: {ID: id}
        }).then(function() {
            var row = document.querySelector('tr[data-id="'+id+'"]')
            row.parentNode.removeChild(row)
        }).catch(function(err) {
            console.log(err)
        })
    }
</script>
</body>
</html>

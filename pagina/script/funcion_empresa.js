document.addEventListener('DOMContentLoaded', function() {
    let isEmployeesVisible = false;
    let isOrdersVisible = false;

    document.getElementById('toggleEmployeesButton').addEventListener('click', function() {
        isEmployeesVisible = !isEmployeesVisible;
        document.getElementById('employeeTable').style.display = isEmployeesVisible ? 'block' : 'none';
        document.getElementById('employeeFormContainer').style.display = 'none'; // Ocultar el formulario
        if (isEmployeesVisible) {
            loadEmployees();
        }
    });

    document.getElementById('toggleOrdersButton').addEventListener('click', function() {
        isOrdersVisible = !isOrdersVisible;
        document.getElementById('orderTable').style.display = isOrdersVisible ? 'block' : 'none';
        if (isOrdersVisible) {
            loadOrders();
        }
    });

    document.getElementById('addEmployeeButton').addEventListener('click', function() {
        // Alternar la visibilidad del formulario y la tabla de empleados
        if (isEmployeesVisible) {
            document.getElementById('employeeFormContainer').style.display = 'block';
            document.getElementById('employeeTable').style.display = 'none';
        } else {
            // Si los empleados no están visibles, mostrar solo el formulario
            document.getElementById('employeeFormContainer').style.display = 'block';
        }
    });

    document.getElementById('employeeForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../php/guardar_empleado.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                if (response.includes('Empleado guardado correctamente')) {
                    Swal.fire({
                        icon: "success",
                        title: "Empleado guardado",
                        text: "Empleado guardado correctamente.",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('employeeFormContainer').style.display = 'none';
                            if (isEmployeesVisible) {
                                loadEmployees();
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response
                    });
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error al guardar el empleado."
                });
            }
        };
        xhr.send(formData);
    });

    function loadEmployees() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../php/obtener_empleados.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('employeeTableBody').innerHTML = xhr.responseText;
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error al cargar los empleados."
                });
            }
        };
        xhr.send();
    }

    function loadOrders() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../php/obtener_pedidos.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('orderTableBody').innerHTML = xhr.responseText;
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error al cargar los pedidos."
                });
            }
        };
        xhr.send();
    }

    window.marcarEntregado = function(id) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../php/marcar_entregado.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                Swal.fire({
                    icon: "success",
                    title: "Pedido entregado",
                    text: "Pedido marcado como entregado.",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error al marcar el pedido como entregado."
                });
            }
        };
        xhr.send('id=' + id);
    };

    window.deleteEmployee = function(id) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../php/eliminar_empleado.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                Swal.fire({
                    icon: "success",
                    title: "Empleado eliminado",
                    text: "Empleado eliminado correctamente.",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error al eliminar el empleado."
                });
            }
        };
        xhr.send('id=' + id);
    };
});

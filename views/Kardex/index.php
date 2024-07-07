<?php require_once '../../Header.php'; ?>
        <!-- Page content-->
        <div class="container">
            <div class="text-center mt-5">
                <h1>Control de Inventario</h1>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    Complete los datos
                </div>
                <div class="card-body">
                <form action="" id="form-validaciones-kardex" autocomplete="off">
                <!-- primera fila -->
                <div class="row g-2 m-b2">

                    <div class="col-md">
                        <div class="input-group">
                            <div class="form-floating">
                                <select name="idproducto" id="idproducto" class="form-select" required>
                                    <option value="">Seleccione</option>
                                </select>
                                <label for="idproducto">Producto</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="stockactual" disabled>
                            <label for="stockactual">Stock Actual</label>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form-floating">
                            <select name="idcolaborador" id="idcolaborador" class="form-select" required>
                                <option value="">Seleccione</option>
                            </select>
                            <label for="idcolaborador">Colaborador</label>
                        </div>
                    </div>

                </div> <!-- ./primera fila -->

                <!-- segunda fila -->
                <div class="row g-2 mt-2">

                    <div class="col-md">
                        <div class="form-floating">
                            <select name="tipomovimiento" id="tipomovimiento" class="form-select" required>
                                <option value="">Seleccione</option>
                                <option value="E">Entrada</option>
                                <option value="S">Salida</option>
                            </select>
                            <label for="tipomovimiento">Tipo de Movimiento</label>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form-floating">
                            <input type="number" minlength="0" class="form-control" id="cantidad" required>
                            <label for="cantidad">Cantidad</label>
                        </div>
                    </div>

                </div> <!-- ./segunda fila -->

                <!-- Botones -->
                <div class="text-end mt-2">
                    <button type="submit" id="registrar-colaborador" class="btn btn-primary btn-sm">Actualizar Kardex</button>
                    <button type="reset" id="cancelar" class="btn btn-secondary btn-sm">Cancelar Proceso</button>
                </div>
                
            </form>        
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                        Generar reporte Historico del producto
                </div>
                <div class="card-body">

                    <label for="idtipoproducto" class="form-label">Seleccione un Producto:</label>

                    <div class="input-group">
                        <select name="ProductoReporte" id="ProductoReporte" class="form-select">
                            <option value="">Seleccione</option>
                        </select>
                        <button type="button" class="btn btn-primary" id="generar"><i class="fa-solid fa-file-export"></i> Generar PDF</button>
                    </div>
                </div>   
                        
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Core theme JS-->
        <script src="<?= $host ?>/js/scripts.js"></script>
        <script>
    document.addEventListener("DOMContentLoaded", () => {

        const idproductoField = document.querySelector("#idproducto"); 
        const stockactualField = document.querySelector("#stockactual");

        //Función Autoejecutable para mostrar los productos en el select 
        (() => {
            fetch(`../../controllers/producto.controller.php?operacion=getAll`)
                .then(response => response.json())
                .then(data => {
                    const Producto = document.querySelector("#idproducto")
                    data.forEach(row => {
                        const tagOption = document.createElement("option")
                        tagOption.value = row.idproducto
                        tagOption.innerHTML = row.Producto
                        Producto.appendChild(tagOption)
                    });
                })
                .catch(e => { console.error(e) })
        })();

        //Función AutoEjecutable para mostrar los nombre de usuarios de los colaboradores
        (() => {
            fetch(`../../controllers/user.controller.php?operacion=getAll`)
                .then(response => response.json())
                .then(data => {
                    const NomUsuario = document.querySelector("#idcolaborador")
                    data.forEach(row => {
                        const tagOption = document.createElement("option")
                        tagOption.value = row.idcolaborador
                        tagOption.innerHTML = row.nomusuario
                        NomUsuario.appendChild(tagOption)
                    });
                })
                .catch(e => { console.error(e) })
        })();

        //Obtener valor del idproducto
        idproductoField.addEventListener("change", () => {
            const idproducto = idproductoField.value;
            if (idproducto) {
                MostrarStockActual(idproducto);
            }
        });

        //Obtiene el idprodcuto de manera asíncrona 
        async function MostrarStockActual(idproducto) {
            try {
                const response = await fetch(`../../controllers/kardex.controller.php?operacion=mostrarStockActual&idproducto=${idproducto}`);
                const stockactual = await response.json();
                stockactualField.value = stockactual;
            } catch (error) {
                console.error(error);
            }
        }

        // Muestra el stock actual si el idproducto ya tiene valor
        if (idproductoField.value) {
            MostrarStockActual(idproductoField.value);
        }

        //Función para validar si la cantidad es mayor al stock actual 
        //si es mayor no se podrá guardar el registro
        function ValidarCantidadSalida() {
            if (tipomovimiento.value === 'S') {
                if (parseInt(cantidad.value) > parseInt(stockactualField.value)) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "La Cantidad de Salida no puede ser mayor al stock Actual",
                    });
                    return false;
                }
            }
            return true;
        }

        //Función para guardar el registro de kardex
        function GuardarKardex(){
            const params = new FormData()
            params.append("operacion", "add")
            params.append("idproducto", document.querySelector("#idproducto").value)
            params.append("idcolaborador", document.querySelector("#idcolaborador").value)
            params.append("tipomovimiento", document.querySelector("#tipomovimiento").value)
            params.append("cantidad", document.querySelector("#cantidad").value)


            //options > fetch
            const options = {
                'method' : 'POST',
                'body'   : params
            }

            //Ejecutamos el envío asíncrono
            fetch(`../../controllers/kardex.controller.php`, options)
                .then(response => response.json())
                .then(data => {
                    //Limpiar el formulario
                    document.querySelector("#form-validaciones-kardex").reset();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Kardex Actualizado Correctamente",
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch( e => { console.error(e) })
        }

        document.querySelector("#form-validaciones-kardex").addEventListener("submit", (event) => {
            event.preventDefault();

            //Si la cantidad es mayor que el stock actual
            if(!ValidarCantidadSalida()){
                return;
            }

            if(confirm("¿Estás seguro de realizar esta Actualización?")){
                GuardarKardex();
            }
        });
        
    })
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        //Referencia al select y al boton
        const lista = document.querySelector("#ProductoReporte");
        const boton = document.querySelector("#generar");

        //Funcion autoejecutable
        (() => {
            fetch(`../../controllers/producto.controller.php?operacion=getAll`)
                .then(response => response.json())
                .then( data => {
                    data.forEach(row => {
                        const tagOption = document.createElement("option")
                        tagOption.value = row.idproducto
                        tagOption.innerHTML = row.Producto
                        lista.appendChild(tagOption)
                    });
                })
                .catch( e => { console.error(e) })
        })();

        //Obtener el valor de la lista
        lista.addEventListener("change", () => {
            lista.value;
        });

        //Llevar a otra pagina 
        boton.addEventListener("click", () => {
            if(lista.value != ""){
                window.open(`../../views/kardex/reporte.php?idproducto=${lista.value}`,'blank');
            }else{
                Swal.fire("Debe Seleccionar un Producto");
            }
        })
    })
</script>
    </body>
</html>

// 🔧 EJEMPLOS DE USO - API de Clientes

// ================================
// 1. LISTAR TODOS LOS CLIENTES
// ================================
async function listarClientes() {
    try {
        const response = await fetch('/clientes');
        const html = await response.text();
        console.log('Página de clientes cargada');
    } catch (error) {
        console.error('Error al listar clientes:', error);
    }
}

// ================================
// 2. CREAR NUEVO CLIENTE
// ================================
async function crearCliente(datos) {
    try {
        const response = await fetch('/clientes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                nombre: datos.nombre,
                apellido: datos.apellido,
                email: datos.email,
                telefono: datos.telefono,
                direccion: datos.direccion
            })
        });

        if (response.ok) {
            console.log('Cliente creado exitosamente');
            return await response.json();
        } else {
            const errors = await response.json();
            console.error('Errores de validación:', errors);
        }
    } catch (error) {
        console.error('Error al crear cliente:', error);
    }
}

// Ejemplo de uso:
/*
crearCliente({
    nombre: 'Juan',
    apellido: 'Pérez',
    email: 'juan@example.com',
    telefono: '+34 612345678',
    direccion: 'Calle Principal 123'
});
*/

// ================================
// 3. EDITAR CLIENTE EXISTENTE
// ================================
async function editarCliente(id, datos) {
    try {
        const response = await fetch(`/clientes/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                nombre: datos.nombre,
                apellido: datos.apellido,
                email: datos.email,
                telefono: datos.telefono,
                direccion: datos.direccion
            })
        });

        if (response.ok) {
            console.log('Cliente actualizado exitosamente');
            return await response.json();
        } else {
            const errors = await response.json();
            console.error('Errores de validación:', errors);
        }
    } catch (error) {
        console.error('Error al actualizar cliente:', error);
    }
}

// Ejemplo de uso:
/*
editarCliente(1, {
    nombre: 'Juan',
    apellido: 'López',
    email: 'juan.lopez@example.com',
    telefono: '+34 612345678',
    direccion: 'Calle Nueva 456'
});
*/

// ================================
// 4. ELIMINAR CLIENTE
// ================================
async function eliminarCliente(id) {
    try {
        const confirmacion = confirm('¿Estás seguro de que deseas eliminar este cliente?');
        if (!confirmacion) return;

        const response = await fetch(`/clientes/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (response.ok) {
            console.log('Cliente eliminado exitosamente');
            return true;
        } else {
            console.error('Error al eliminar cliente');
            return false;
        }
    } catch (error) {
        console.error('Error al eliminar cliente:', error);
        return false;
    }
}

// Ejemplo de uso:
/*
eliminarCliente(1);
*/

// ================================
// 5. OBTENER CLIENTE POR ID (API)
// ================================
async function obtenerCliente(id) {
    try {
        const response = await fetch(`/api/clientes/${id}`);
        const cliente = await response.json();
        console.log('Cliente obtenido:', cliente);
        return cliente;
    } catch (error) {
        console.error('Error al obtener cliente:', error);
    }
}

// ================================
// 6. VALIDAR EMAIL ANTES DE GUARDAR
// ================================
async function validarEmail(email, clienteId = null) {
    try {
        // Este es un ejemplo - necesitarías crear un endpoint en el controlador
        const response = await fetch('/clientes/validar-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                email: email,
                cliente_id: clienteId
            })
        });

        const result = await response.json();
        return result.disponible;
    } catch (error) {
        console.error('Error al validar email:', error);
    }
}

// ================================
// 7. BÚSQUEDA DE CLIENTES EN TIEMPO REAL
// ================================
async function buscarClientes(termino) {
    try {
        // Este es un ejemplo - necesitarías crear un endpoint en el controlador
        const response = await fetch(`/clientes/buscar?q=${encodeURIComponent(termino)}`);
        const resultados = await response.json();
        console.log('Resultados de búsqueda:', resultados);
        return resultados;
    } catch (error) {
        console.error('Error en búsqueda:', error);
    }
}

// Ejemplo con evento de entrada:
/*
document.getElementById('searchInput').addEventListener('keyup', function(e) {
    const termino = e.target.value;
    if (termino.length > 2) {
        buscarClientes(termino);
    }
});
*/

// ================================
// 8. VALIDADOR DE FORMULARIO
// ================================
function validarFormulario(datos) {
    const errores = [];

    if (!datos.nombre || datos.nombre.length < 3) {
        errores.push('El nombre debe tener al menos 3 caracteres');
    }

    if (!datos.apellido || datos.apellido.length < 3) {
        errores.push('El apellido debe tener al menos 3 caracteres');
    }

    if (!datos.email || !datos.email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        errores.push('El email no es válido');
    }

    if (!datos.telefono || datos.telefono.length < 7) {
        errores.push('El teléfono debe tener al menos 7 caracteres');
    }

    return {
        valido: errores.length === 0,
        errores: errores
    };
}

// Ejemplo de uso:
/*
const resultado = validarFormulario({
    nombre: 'Juan',
    apellido: 'Pérez',
    email: 'juan@example.com',
    telefono: '612345678'
});

if (resultado.valido) {
    crearCliente({...});
} else {
    console.log('Errores:', resultado.errores);
}
*/

// ================================
// 9. TABLA DINÁMICA CON CLIENTES
// ================================
async function cargarClientesEnTabla() {
    try {
        const response = await fetch('/clientes');
        const html = await response.text();
        
        // Parsear HTML y extraer datos (alternativa: usar JSON API)
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const filas = doc.querySelectorAll('tbody tr');
        
        console.log(`Se encontraron ${filas.length} clientes`);
        
        filas.forEach(fila => {
            const id = fila.cells[0].textContent;
            const nombre = fila.cells[1].textContent;
            const email = fila.cells[2].textContent;
            console.log(`${id}: ${nombre} (${email})`);
        });
    } catch (error) {
        console.error('Error al cargar tabla:', error);
    }
}

// ================================
// 10. EXPORTAR CLIENTES A CSV
// ================================
function exportarClientesCSV() {
    try {
        const tabla = document.querySelector('table');
        let csv = [];
        
        // Headers
        const headers = [];
        tabla.querySelectorAll('thead th').forEach(th => {
            headers.push(th.textContent.trim());
        });
        csv.push(headers.join(','));
        
        // Datos
        tabla.querySelectorAll('tbody tr').forEach(tr => {
            const fila = [];
            tr.querySelectorAll('td').forEach(td => {
                fila.push(`"${td.textContent.trim()}"`);
            });
            csv.push(fila.join(','));
        });
        
        // Descargar
        const blob = new Blob([csv.join('\n')], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `clientes_${new Date().toISOString().split('T')[0]}.csv`;
        link.click();
    } catch (error) {
        console.error('Error al exportar CSV:', error);
    }
}

// ================================
// INICIALIZACIÓN
// ================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 API de Clientes lista');
    console.log('Funciones disponibles:');
    console.log('- listarClientes()');
    console.log('- crearCliente(datos)');
    console.log('- editarCliente(id, datos)');
    console.log('- eliminarCliente(id)');
    console.log('- obtenerCliente(id)');
    console.log('- validarEmail(email)');
    console.log('- buscarClientes(termino)');
    console.log('- validarFormulario(datos)');
    console.log('- cargarClientesEnTabla()');
    console.log('- exportarClientesCSV()');
});

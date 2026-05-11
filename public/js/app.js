// URL de la API (ajustar según el entorno, por ejemplo: http://localhost/sabandoErasers/api.php)
const API_URL = '../api.php';

document.addEventListener('DOMContentLoaded', () => {
    
    // Si estamos en index.html, cargamos los profesores
    const professorsTable = document.getElementById('professorsTable');
    if (professorsTable) {
        loadProfessors();
    }

    // Si estamos en create.html, manejamos el formulario
    const createForm = document.getElementById('createProfessorForm');
    if (createForm) {
        createForm.addEventListener('submit', handleCreateProfessor);
    }
});

/**
 * Carga los profesores desde la API y los renderiza en la tabla
 */
async function loadProfessors() {
    const tbody = document.querySelector('#professorsTable tbody');
    
    try {
        const response = await fetch(API_URL);
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.error || 'Error fetching data');
        }
        
        const professors = data;
        tbody.innerHTML = ''; // Limpiar mensaje de carga

        if (!Array.isArray(professors) || professors.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No professors found.</td></tr>';
            return;
        }

        professors.forEach(prof => {
            // Valor Computado (Rúbrica: 10 points)
            // Calculamos el bono basado en los años de servicio.
            const bonusHtml = calculateBonus(prof.hireDate, prof.salary);

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${prof.id}</td>
                <td>${prof.fullname}</td>
                <td>${prof.department}</td>
                <td>${prof.email}</td>
                <td>${prof.hireDate}</td>
                <td>${bonusHtml}</td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        console.error(error);
        tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: red;">Error: ${error.message}</td></tr>`;
    }
}

/**
 * Calcula un bono dinámico basado en los años de servicio
 * (Valor computado requerido por la rúbrica)
 */
function calculateBonus(hireDateStr, baseSalary) {
    const hireDate = new Date(hireDateStr);
    const today = new Date();
    
    let yearsOfService = today.getFullYear() - hireDate.getFullYear();
    const m = today.getMonth() - hireDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < hireDate.getDate())) {
        yearsOfService--;
    }

    let bonusPercentage = 0;
    if (yearsOfService >= 10) {
        bonusPercentage = 0.15; // 15% bonus
    } else if (yearsOfService >= 5) {
        bonusPercentage = 0.10; // 10% bonus
    } else if (yearsOfService >= 2) {
        bonusPercentage = 0.05; // 5% bonus
    }

    if (bonusPercentage > 0) {
        const bonusAmount = (parseFloat(baseSalary) * bonusPercentage).toFixed(2);
        return `<span style="color: green; font-weight: bold;">+$${bonusAmount}</span> <small>(${bonusPercentage * 100}%)</small>`;
    } else {
        return `<span style="color: var(--text-muted);">No bonus yet</span>`;
    }
}

/**
 * Maneja el envío del formulario para crear un nuevo profesor
 */
async function handleCreateProfessor(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    const messageDiv = document.getElementById('formMessage');
    messageDiv.textContent = 'Saving...';
    messageDiv.style.color = 'var(--text-main)';

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            messageDiv.textContent = 'Professor saved successfully!';
            messageDiv.style.color = 'green';
            form.reset();
        } else {
            throw new Error(result.error || 'Unknown error');
        }
    } catch (error) {
        console.error(error);
        messageDiv.textContent = 'Error: ' + error.message;
        messageDiv.style.color = 'red';
    }
}

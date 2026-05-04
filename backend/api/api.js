
function login(email, password) {
    return fetch('api/login.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({email, password})
    })
        .then(r => r.json())
}

function seDeconnecter(){
    localStorage.removeItem('session');
    window.location.href = '01_accueil.html';
}

function getSession() {
    const session = localStorage.getItem('session');
    return session ? JSON.parse(session) : null;
}

function setSession(user) {
    if (user) {
        localStorage.setItem('session', JSON.stringify(user));
    } else {
        localStorage.removeItem('session');
    }
}

function getOffres(search = undefined) {
    if (search) {
        return fetch('api/offres.php?search=' + encodeURIComponent(search))
            .then(r => r.json());
    }
    return fetch('api/offres.php')
        .then(r => r.json());
}

function getOffresById(id) {
    return fetch('api/offres.php?id=' + encodeURIComponent(id))
        .then(r => r.json())
        .then(data => data || []);  // Retourne un tableau vide si null
}

   function getOffresByVendeur(vendeurId) {
       return fetch('api/offres.php?vendeur_id=' + encodeURIComponent(vendeurId))
           .then(r => r.json());
   }

function addOffre(payload) {
    return fetch('api/offres.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'create', ...payload })
    })
        .then(r => r.json());
}

function updateOffre(id, payload) {
    return fetch('api/offres.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'update', id, ...payload })
    })
        .then(r => r.json());
}

function deleteOffre(id) {
    return fetch('api/offres.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'delete', id })
    })
        .then(r => r.json());
}

// Fonctions API pour les utilisateurs
function getAllUsers() {
    return fetch('api/utilisateurs.php')
        .then(r => r.json());
}

function deleteUser(id) {
    return fetch('api/utilisateurs.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'delete', id })
    })
        .then(r => r.json());
}


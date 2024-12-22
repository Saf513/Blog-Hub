document.addEventListener('DOMContentLoaded', () => {
    // header
    var toggleOpen = document.getElementById('toggleOpen');
    var toggleClose = document.getElementById('toggleClose');
    var collapseMenu = document.getElementById('collapseMenu');

    function handleClick() {
      if (collapseMenu.style.display === 'block') {
        collapseMenu.style.display = 'none';
      } else {
        collapseMenu.style.display = 'block';
      }
    }

    toggleOpen.addEventListener('click', handleClick);
    toggleClose.addEventListener('click', handleClick);

    // sidebar
    let sidebarToggleBtn = document.getElementById('toggle-sidebar');
    let sidebar = document.getElementById('sidebar');
    let sidebarCollapseMenu = document.getElementById('sidebar-collapse-menu');

    sidebarToggleBtn.addEventListener('click', () => {
      if (!sidebarCollapseMenu.classList.contains('open')) {
          sidebarCollapseMenu.classList.add('open');
          sidebarCollapseMenu.style.cssText = 'width: 250px; visibility: visible; opacity: 1;';
          sidebarToggleBtn.style.cssText = 'left: 236px;';
      } else {
          sidebarCollapseMenu.classList.remove('open');
          sidebarCollapseMenu.style.cssText = 'width: 32px; visibility: hidden; opacity: 0;';
          sidebarToggleBtn.style.cssText = 'left: 10px;';
      }

    });
  });

function handleTagInput(event) {
    const tagInput = document.getElementById('tag-input');
    const tagList = document.getElementById('tag-list');
    // const tagsHiddenInput = document.getElementById('tags-hidden-input');

    if (event.key === 'Enter' && tagInput.value.trim() !== '') {
        event.preventDefault();

        const tagText = tagInput.value.trim();
        const tagElement = document.createElement('span');
        tagElement.classList.add('bg-blue-100', 'text-blue-700', 'px-3', 'py-1', 'rounded-full', 'flex', 'items-center');
        tagElement.textContent = tagText;

        tagList.appendChild(tagElement);

        const removeBtn = document.createElement('button');
        removeBtn.classList.add('ml-2', 'text-blue-500');
        removeBtn.textContent = '×';
        removeBtn.onclick = function () {
            tagList.removeChild(tagElement);
            updateHiddenInput();
        };
        tagElement.appendChild(removeBtn);

        tagInput.value = '';
        updateHiddenInput();
    }
}

function updateHiddenInput() {
    const tags = [];
    const tagElements = document.querySelectorAll('#tag-list span');
    tagElements.forEach(tag => {
        tags.push(tag.textContent.replace('×', '').trim());
    });
    document.getElementById('tags-hidden-input').value = tags.join(',');
}

let likeButton = document.getElementById('likeButton');
let likeCountButton = document.getElementById('likeCountButton');
let currentLikes = parseInt(likeCountButton.textContent, 10);

likeButton.addEventListener('click', function () {
    currentLikes += 1;
    likeCountButton.textContent = currentLikes;

    // Appeler une fonction pour envoyer cette mise à jour au serveur
    updateLikesOnServer(currentLikes);
});

// Fonction AJAX pour envoyer la mise à jour au serveur
function updateLikesOnServer(likes) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_likes.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Logique en cas de succès (par exemple, afficher un message de succès)
            console.log('Like updated on server!');
        }
    };
    // Envoyer la requête avec le nombre de likes
    xhr.send('likes=' + likes);
}
document.addEventListener('DOMContentLoaded', function () {
    console.log("Le fichier app.js est correctement chargé !");
});


// // JavaScript pour gérer l'ajout de commentaire avec AJAX

// // Sélectionner les éléments du DOM
// const addCommentButton = document.getElementById('addComment');
// const commentInput = document.getElementById('newComment');
// const commentsList = document.getElementById('commentsList');
const commentModal = document.getElementById('commentModal');
const closeModalButton = document.getElementById('closeModal');
const openModal = document.getElementById('openModal');
// const articleId = document.getElementById('articleId').value;

// // Lorsque l'utilisateur clique sur "Ajouter"
// addCommentButton.addEventListener('click', function () {
//     const commentContent = commentInput.value.trim();
//     if (commentContent === "") {
//         alert("Veuillez entrer un commentaire.");
//         return;
//     }

//     const formData = new FormData();
//     formData.append('content', commentContent);  
//     formData.append('article_id', articleId); 
//     fetch('ajouter_commentaire.php', {
//         method: 'POST',
//         body: formData
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 // Ajouter le nouveau commentaire à la liste des commentaires dans le modal
//                 const newComment = document.createElement('div');
//                 newComment.textContent = `${data.user_name} - ${data.created_at}: ${commentContent}`;
//                 commentsList.appendChild(newComment);

//                 // Vider le champ de texte
//                 commentInput.value = '';

//                 // // Fermer le modal
//                 // commentModal.classList.add('hidden');
//             } else {
//                 alert("Erreur lors de l'ajout du commentaire.");
//             }
//         })
//         .catch(error => {
//             console.error("Erreur AJAX :", error);
//             alert("Une erreur est survenue. Veuillez réessayer.");
//         });
// });

// Lorsque l'utilisateur clique sur "fermer", fermer le modal
closeModalButton.addEventListener('click', function () {
    commentModal.classList.add('hidden');
});
openModal.addEventListener('click', function () {

    commentModal.classList.remove('hidden');
});


// ajouter un commentaire 
document.addEventListener('DOMContentLoaded', () => {
    // Fonction pour envoyer un commentaire via AJAX
    function addComment() {
        const commentContent = document.getElementById('newComment').value;
        const articleId = document.getElementById('articleId').value;

        if (commentContent.trim() === '') {
            alert('Le contenu du commentaire ne peut pas être vide');
            return;
        }

        // Créer un objet FormData pour envoyer les données via POST
        const formData = new FormData();
        formData.append('content', commentContent);
        formData.append('article_id', articleId);

        // Envoi AJAX via Fetch
        fetch('ajouter_commentaire.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Ajouter le commentaire dans la liste de la modal
                    const commentsList = document.querySelector('#commentsList');
                    const commentDiv = document.createElement('div');
                    commentDiv.classList.add('comment', 'mb-4', 'p-4', 'bg-gray-100', 'rounded-md', 'shadow-md', 'border', 'border-gray-300');

                    const commentDate = `Créé le : ${new Date(data.created_at).toLocaleString()}`;

                    commentDiv.innerHTML = `
                    <p><strong>${data.user_name}</strong> - <span class="text-sm text-gray-500">${commentDate}</span></p>
                    <p class="mt-2 text-gray-700">${data.content}</p>
                `;

                    // Ajouter le nouveau commentaire dans la modal
                    commentsList.appendChild(commentDiv);

                    // Réinitialiser le champ de saisie du commentaire
                    document.getElementById('newComment').value = '';
                } else {
                    alert('Erreur : ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'ajout du commentaire:', error);
            });
    }

    // Ajouter l'événement d'ajout de commentaire
    document.getElementById('addComment').addEventListener('click', (event) => {
        event.preventDefault();
        addComment();
    });
});

//EDITER UNE PUBLICATION 
let dropdownToggle = document.getElementById('dropdownToggle');
let dropdownMenu = document.getElementById('dropdownMenu');

function handleClick() {
    if (dropdownMenu.className.includes('block')) {
        dropdownMenu.classList.add('hidden')
        dropdownMenu.classList.remove('block')
    } else {
        dropdownMenu.classList.add('block')
        dropdownMenu.classList.remove('hidden')
    }
}

dropdownToggle.addEventListener('click', handleClick);

let container=document.querySelector('.main-content');
let aricles=document.querySelector('#articles');
let btnArticle=document.querySelector('#articles_btn');

btnArticle.addEventListener('clic',()=>{
container.style.display='none';
})


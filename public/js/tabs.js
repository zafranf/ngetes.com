let hash = location.hash;
if (hash.length) {
    let id = hash.replace("#", "");
    toggleTab('li-' + id, id);
    console.log('ini hash', hash);
} else {
    let path = location.pathname;
    if (path.length) {
        let id = path.replace("/", "");
        if (!id.length) {
            id = 'tentang';
        }
        toggleTab('li-' + id, id);
        console.log('ini id path', id);
    }
    console.log('ini path', path);
}

document.querySelectorAll("#nav li").forEach(function(navEl) {
    navEl.onclick = function() {
        toggleTab(this.id, this.dataset.target);
    }
});

function toggleTab(selectedNav, targetId) {
    var navEls = document.querySelectorAll("#nav li");
    navEls.forEach(function(navEl) {
        if (navEl.id == selectedNav) {
            navEl.classList.add("is-active");
        } else {
            if (navEl.classList.contains("is-active")) {
                navEl.classList.remove("is-active");
            }
        }
    });

    var tabs = document.querySelectorAll(".tab-pane");
    tabs.forEach(function(tab) {
        if (tab.id == targetId) {
            tab.classList.add("is-active");
            tab.style.display = "block";
        } else {
            tab.classList.remove("is-active");
            tab.style.display = "none";
        }
    });

    /* if (history.pushState) {
        history.pushState(null, null, '#' + targetId);
    } else {
        location.hash = '#' + targetId;
    } */
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    return re.test(String(email).toLowerCase());
}
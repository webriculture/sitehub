const body = document.body;
const menuToggle = document.querySelector('[data-menu-toggle]');
const nav = document.querySelector('[data-nav]');
const header = document.querySelector('[data-header]');

if (menuToggle && nav) {
  menuToggle.addEventListener('click', () => {
    const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', String(!isOpen));
    nav.classList.toggle('is-open', !isOpen);
    body.classList.toggle('menu-open', !isOpen);
  });

  nav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      menuToggle.setAttribute('aria-expanded', 'false');
      nav.classList.remove('is-open');
      body.classList.remove('menu-open');
    });
  });
}

const revealItems = document.querySelectorAll('.reveal');

if ('IntersectionObserver' in window) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  revealItems.forEach((item) => observer.observe(item));
} else {
  revealItems.forEach((item) => item.classList.add('is-visible'));
}

const filterButtons = document.querySelectorAll('[data-filter]');
const classCards = document.querySelectorAll('.class-card');
const noResults = document.querySelector('[data-no-results]');
const searchForm = document.querySelector('[data-class-search]');
const keywordInput = document.querySelector('#class-keyword');
let activeFilter = 'all';

function filterClasses() {
  const keyword = keywordInput ? keywordInput.value.trim().toLowerCase() : '';
  let visibleCount = 0;

  classCards.forEach((card) => {
    const tags = card.dataset.tags || '';
    const text = card.textContent.toLowerCase();
    const matchesFilter = activeFilter === 'all' || tags.includes(activeFilter);
    const matchesKeyword = keyword === '' || text.includes(keyword);
    const shouldShow = matchesFilter && matchesKeyword;

    card.hidden = !shouldShow;
    if (shouldShow) visibleCount += 1;
  });

  if (noResults) noResults.hidden = visibleCount !== 0;
}

filterButtons.forEach((button) => {
  button.addEventListener('click', () => {
    filterButtons.forEach((btn) => btn.classList.remove('active'));
    button.classList.add('active');
    activeFilter = button.dataset.filter || 'all';
    filterClasses();
  });
});

if (searchForm) {
  searchForm.addEventListener('submit', (event) => {
    event.preventDefault();
    filterClasses();
  });
}

if (keywordInput) {
  keywordInput.addEventListener('input', filterClasses);
}

function updateHeaderState() {
  if (!header) return;
  header.classList.toggle('is-scrolled', window.scrollY > 30);
}

updateHeaderState();
window.addEventListener('scroll', updateHeaderState, { passive: true });

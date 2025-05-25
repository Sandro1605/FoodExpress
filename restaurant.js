const isLoggedIn = sessionStorage.getItem("userRole") === "customer";
let cart = [];

function addToCart(itemName, price) {
  cart.push({ name: itemName, price: price });
  updateCartUI();
}

function updateCartUI() {
  const cartList = document.getElementById("cartList");
  const cartTotal = document.getElementById("cartTotal");
  cartList.innerHTML = "";

  let total = 0;
  cart.forEach((item) => {
    const li = document.createElement("li");
    li.textContent = `${item.name} - Rp ${item.price.toLocaleString()}`;
    cartList.appendChild(li);
    total += item.price;
  });

  cartTotal.textContent = total.toLocaleString();
}

function checkout() {
  if (!isLoggedIn) return showAlert();
  if (cart.length === 0) {
    alert("Keranjang kosong!");
    return;
  }

  const orderSummary = cart
    .map(item => `- ${item.name} (Rp ${item.price.toLocaleString()})`)
    .join("\n");

  alert("Pesanan Anda:\n" + orderSummary + `\n\nTotal: Rp ${getTotal().toLocaleString()}`);
  cart = [];
  updateCartUI();
}

function getTotal() {
  return cart.reduce((sum, item) => sum + item.price, 0);
}

function showAlert() {
  const box = document.getElementById("alertBox");
  if (box) {
    box.style.display = "block";
    setTimeout(() => {
      box.style.display = "none";
    }, 2500);
  }
}



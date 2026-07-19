<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mystery Box</title>
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --orange:#f2621f;
    --orange-dark:#e2530f;
    --card-bg:#fff;
    --text-dark:#1c2b4a;
    --text-muted:#5b6b85;
    --border:#eee0d6;
    --page-bg:#f2621f;
  }
  *{box-sizing:border-box;}
  body{
    margin:0;
    background:var(--page-bg);
    font-family:'Hind Siliguri', sans-serif;
    color:var(--text-dark);
    display:flex;
    justify-content:center;
    padding:24px 16px;
  }
  .wrap{
    width:100%;
    max-width:480px;
    display:flex;
    flex-direction:column;
    gap:16px;
  }
  .card{
    background:var(--card-bg);
    border-radius:14px;
    padding:20px;
    box-shadow:0 2px 10px rgba(0,0,0,0.06);
  }

  /* Header */
  .header-card{
    display:flex;
    align-items:center;
    gap:12px;
    padding:16px 20px;
  }
  .logo-badge{
    width:36px;
    height:36px;
    border-radius:8px;
    background:var(--orange);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
  }
  .header-text .eyebrow{
    font-size:12px;
    color:var(--text-muted);
    margin:0 0 2px;
  }
  .header-text .brand{
    font-size:18px;
    font-weight:700;
    color:var(--orange);
    margin:0;
  }

  /* Offer card */
  .offer-card{
    text-align:center;
  }
  .offer-eyebrow{
    font-size:13px;
    color:var(--text-muted);
    margin:0 0 4px;
  }
  .offer-title{
    font-size:22px;
    font-weight:700;
    color:var(--text-dark);
    margin:0 0 16px;
  }
  .hero-img{
    position:relative;
    border-radius:10px;
    overflow:hidden;
    background:radial-gradient(circle at 50% 40%, #ff7a3d 0%, var(--orange) 60%, var(--orange-dark) 100%);
    height:200px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:20px;
  }
  .hero-box-label{
    background:#7a1620;
    color:#fff;
    font-weight:800;
    font-size:26px;
    line-height:1.1;
    text-align:center;
    padding:14px 30px;
    border-radius:4px;
    transform:rotate(-3deg);
    box-shadow:4px 4px 0 rgba(0,0,0,0.15);
    letter-spacing:1px;
  }
  .cod-tag{
    position:absolute;
    bottom:10px;
    left:50%;
    transform:translateX(-50%);
    background:rgba(0,0,0,0.55);
    color:#fff;
    font-size:11px;
    padding:4px 12px;
    border-radius:20px;
  }

  .timer-box{
    background:#fff7f0;
    border:1px solid #ffd8bd;
    border-radius:10px;
    padding:14px;
    margin-bottom:18px;
  }
  .timer-label{
    color:var(--orange);
    font-size:13px;
    font-weight:600;
    margin:0 0 6px;
  }
  .timer-clock{
    font-size:28px;
    font-weight:700;
    color:var(--text-dark);
    display:flex;
    justify-content:center;
    align-items:baseline;
    gap:8px;
  }
  .timer-sub{
    display:flex;
    justify-content:center;
    gap:44px;
    font-size:11px;
    color:var(--text-muted);
    margin-top:2px;
  }

  .pack-options{
    display:flex;
    gap:10px;
    margin-bottom:18px;
  }
  .pack{
    flex:1;
    border:1.5px solid #e5e5e5;
    border-radius:10px;
    padding:10px 6px;
    text-align:center;
    cursor:pointer;
    transition:all .15s ease;
  }
  .pack.active{
    border-color:var(--orange);
    background:#fff3ea;
  }
  .pack-name{
    font-size:12px;
    color:var(--text-muted);
    margin:0 0 4px;
  }
  .pack-img {
    width: 50px;
    height: 50px;
    object-fit: contain;
    display: block;
    margin: 0 auto 6px;
    transition: transform 0.2s;
  }
  .pack:hover .pack-img {
    transform: scale(1.08);
  }
  .pack-price{
    font-size:14px;
    font-weight:700;
    color:var(--text-dark);
    margin:0;
  }

  .summary-box{
    border:1px solid var(--border);
    border-radius:10px;
    padding:14px 16px;
    margin-bottom:18px;
    text-align:left;
  }
  .summary-row{
    display:flex;
    justify-content:space-between;
    font-size:14px;
    color:var(--text-muted);
    padding:5px 0;
  }
  .summary-row.total{
    border-top:1px dashed var(--border);
    margin-top:6px;
    padding-top:10px;
    font-weight:700;
    color:var(--text-dark);
    font-size:16px;
  }

  .btn-primary{
    display:block;
    width:100%;
    background:var(--orange);
    color:#fff;
    border:none;
    border-radius:10px;
    padding:15px;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    font-family:inherit;
  }
  .btn-primary:hover{ background:var(--orange-dark); }

  /* Billing form */
  .form-title{
    font-size:18px;
    font-weight:700;
    text-align:center;
    margin:0 0 4px;
  }
  .form-sub{
    font-size:13px;
    color:var(--text-muted);
    text-align:center;
    margin:0 0 18px;
  }
  label{
    display:block;
    font-size:13px;
    font-weight:600;
    margin-bottom:6px;
  }
  label .req{ color:var(--orange); }
  input, textarea{
    width:100%;
    border:1px solid #e2e2e2;
    border-radius:8px;
    padding:11px 12px;
    font-size:14px;
    font-family:inherit;
    margin-bottom:16px;
    color:var(--text-dark);
  }
  input::placeholder, textarea::placeholder{ color:#b7b7b7; }
  textarea{ resize:vertical; min-height:70px; }

  .form-note{
    font-size:12px;
    color:var(--text-muted);
    text-align:center;
    margin-top:10px;
    line-height:1.5;
  }

  /* Policy sections */
  .section-title{
    font-size:18px;
    font-weight:700;
    text-align:center;
    margin:0 0 16px;
  }
  .policy-item{
    border:1px solid var(--border);
    border-radius:10px;
    padding:14px 16px;
    margin-bottom:12px;
  }
  .policy-item:last-child{ margin-bottom:0; }
  .policy-item h4{
    margin:0 0 6px;
    font-size:14px;
    color:var(--orange-dark);
  }
  .policy-item p, .policy-item li{
    font-size:13px;
    color:var(--text-muted);
    margin:0;
    line-height:1.6;
  }
  .policy-item ul{
    margin:0;
    padding-left:18px;
  }
  .policy-item ul li{ margin-bottom:6px; }
  .policy-item ul li:last-child{ margin-bottom:0; }

  .footer-card{
    text-align:center;
    padding:20px;
  }
  .footer-card .fbrand{
    font-weight:700;
    margin:0 0 4px;
  }
  .footer-card .fcopy{
    font-size:12px;
    color:var(--text-muted);
    margin:0;
  }
  .warning-box{
    background:#fff5f5;
    border:1px solid #feb2b2;
    border-radius:10px;
    padding:14px;
    margin-bottom:16px;
    text-align:center;
  }
  .warning-title{
    color:#e53e3e;
    font-size:15px;
    font-weight:700;
    margin:0 0 6px;
  }
  .warning-text{
    font-size:13px;
    color:#4a5568;
    line-height:1.6;
    margin:0;
  }
</style>
</head>
<body>
<div class="wrap">

  <!-- Header -->
  <div class="card header-card">
    <div class="logo-badge">🎁</div>
    <div class="header-text">
      <p class="eyebrow">অফিশিয়াল অফার</p>
      <p class="brand">Mystery Box</p>
    </div>
  </div>

  <!-- Offer -->
  <div class="card offer-card">
    <p class="offer-eyebrow">সবার আগে অর্ডার করুন</p>
    <h2 class="offer-title">মিস্ট্রি বক্স অফার</h2>

    <div class="hero-img">
      <div class="hero-box-label">MYSTERY<br>BOX</div>
      <span class="cod-tag">Cash on Delivery</span>
    </div>

    <div class="timer-box">
      <p class="timer-label">সীমিত সময়ের জন্য অফার!</p>
      <div class="timer-clock">
        <span id="minutes">11</span><span>:</span><span id="seconds">51</span>
      </div>
      <div class="timer-sub">
        <span>মিনিট</span><span>সেকেন্ড</span>
      </div>
    </div>

    <div class="pack-options">
      <div class="pack active" data-price="354" data-name="৬ প্যাক">
        <img class="pack-img" src="https://img.icons8.com/color/96/gift--v1.png">
        <p class="pack-name">৬ প্যাক</p>
        <p class="pack-price">৳ 354.00</p>
      </div>
      <div class="pack" data-price="413" data-name="৭ প্যাক">
        <img class="pack-img" src="https://img.icons8.com/color/96/gift--v1.png">
        <p class="pack-name">৭ প্যাক</p>
        <p class="pack-price">৳ 413.00</p>
      </div>
      <div class="pack" data-price="590" data-name="১০ প্যাক">
        <img class="pack-img" src="https://img.icons8.com/color/96/gift--v1.png">
        <p class="pack-name">১০ প্যাক</p>
        <p class="pack-price">৳ 590.00</p>
      </div>
    </div>

    <div class="summary-box">
      <div class="summary-row"><span>নির্বাচিত প্যাকেজ</span><span id="sumPack">৬ প্যাক</span></div>
      <div class="summary-row"><span>পণ্যের মূল্য</span><span id="sumPrice">৳ 354.00</span></div>
      <div class="summary-row"><span>ক্যাশ অন ডেলিভারি চার্জ</span><span>৳ 99.00</span></div>
      <div class="summary-row total"><span>মোট</span><span id="sumTotal">৳ 453.00</span></div>
    </div>

    <div class="warning-box">
      <div class="warning-title">⚠️ সতর্ক বার্তা ⚠️</div>
      <div class="warning-text">Mystery Box মানে আপনার ভাগ্যের পরীক্ষা! সম্পূর্ণ টাকা পরিশোধ করে বক্সটি আনবক্স করবেন। ধন্যবাদ ❤️</div>
    </div>

    <button class="btn-primary" id="btn-order-now">🛒 অর্ডার করতে চাই</button>
  </div>

  <!-- Billing form -->
  <div class="card" id="billing-form">
    <h3 class="form-title">বিলিং তথ্য</h3>
    <p class="form-sub">অর্ডার কনফার্ম করতে নিচের ফর্মটি পূরণ করুন।</p>

    <div id="form-container">
      <label>নাম <span class="req">*</span></label>
      <input type="text" id="customer_name" placeholder="আপনার নাম" required>

      <label>ডেলিভারি ঠিকানা <span class="req">*</span></label>
      <input type="text" id="address" placeholder="বাড়ি / রোড / এলাকা, শহর" required>

      <label>মোবাইল নম্বর <span class="req">*</span></label>
      <input type="text" id="phone" placeholder="01XXXXXXXXX" required>

      <label>নোট (ঐচ্ছিক)</label>
      <textarea id="note" placeholder="বিশেষ কোনো নির্দেশনা থাকলে লিখুন"></textarea>

      <div class="warning-box">
        <div class="warning-title">⚠️ সতর্ক বার্তা ⚠️</div>
        <div class="warning-text">Mystery Box মানে আপনার ভাগ্যের পরীক্ষা! সম্পূর্ণ টাকা পরিশোধ করে বক্সটি আনবক্স করবেন। ধন্যবাদ ❤️</div>
      </div>

      <button class="btn-primary" id="btn-confirm-order">অর্ডার কনফার্ম করুন</button>
    </div>
    <p class="form-note">অর্ডার করার আগে অনুগ্রহ করে নিচের অর্ডার পলিসি ও রিটার্ন পলিসি ভালোভাবে পড়ে নিন।</p>
  </div>

  <!-- Order policy -->
  <div class="card">
    <h3 class="section-title">অর্ডার নীতিমালা</h3>

    <div class="policy-item">
      <h4>পেমেন্ট পদ্ধতি</h4>
      <p>সারা বাংলাদেশে ক্যাশ অন ডেলিভারি সুবিধা রয়েছে।</p>
    </div>

    <div class="policy-item">
      <h4>ন্যূনতম অর্ডার</h4>
      <p>অর্ডার করতে অবশ্যই উপলব্ধ প্যাকেজগুলোর (৬ / ৭ / ১০ প্যাক) যেকোনো একটি নির্বাচন করতে হবে।</p>
    </div>

    <div class="policy-item">
      <h4>ডেলিভারি চার্জ</h4>
      <p>মোট অর্ডারের সাথে নির্ধারিত ডেলিভারি চার্জ যোগ করা হবে।</p>
    </div>

    <div class="policy-item">
      <h4>ডেলিভারি প্রক্রিয়া</h4>
      <p>অর্ডারকৃত পণ্য সিল করা মিস্ট্রি বক্স হিসেবে ডেলিভারি করা হবে। বক্স খোলার আগে পণ্য চেক করার সুযোগ নেই, কারণ বক্সের ভিতরে কী থাকবে তা সম্পূর্ণ আপনার ভাগ্যের উপর নির্ভর করে।</p>
    </div>

    <div class="policy-item">
      <h4>অর্ডার নিশ্চিতকরণ</h4>
      <p>ডেলিভারির আগে আমাদের টিম আপনার অর্ডার নিশ্চিত করতে কল করতে পারে।</p>
    </div>
  </div>

  <!-- Return policy -->
  <div class="card">
    <h3 class="section-title">রিটার্ন নীতিমালা</h3>

    <div class="policy-item">
      <h4>রিটার্ন করার নিয়ম</h4>
      <ul>
        <li>পার্সেল খোলার সময় অবশ্যই আনবক্সিং ভিডিও করতে হবে।</li>
        <li>ডেলিভারির ২৪ ঘণ্টার মধ্যে সমস্যার ক্ষেত্রে সাপোর্টে যোগাযোগ করতে হবে।</li>
        <li>অনুমোদনের পর রিটার্ন পিকআপ হতে ২-৩ দিন সময় লাগতে পারে।</li>
        <li>রিটার্নকৃত পার্সেল গ্রহণের পর রিফান্ড প্রসেস করা হবে।</li>
      </ul>
    </div>

    <div class="policy-item">
      <h4>নোট</h4>
      <p>মিস্ট্রি বক্স সম্পূর্ণ সিল করা অবস্থায় পাঠানো হয়। বক্সের ভিতরে কী থাকবে তা সম্পূর্ণ আপনার ভাগ্যের উপর নির্ভর করে।</p>
    </div>
  </div>

  <div class="card footer-card">
    <p class="fbrand">Mystery Box</p>
    <p class="fcopy">© 2026 সর্বস্বত্ব সংরক্ষিত।</p>
  </div>

</div>

<script>
  // Countdown timer starting at 11:51
  let totalSeconds = 11 * 60 + 51;
  const minEl = document.getElementById('minutes');
  const secEl = document.getElementById('seconds');
  setInterval(() => {
    if(totalSeconds <= 0){ totalSeconds = 11*60+51; }
    totalSeconds--;
    const m = Math.floor(totalSeconds/60);
    const s = totalSeconds%60;
    minEl.textContent = String(m).padStart(2,'0');
    secEl.textContent = String(s).padStart(2,'0');
  }, 1000);

  // Pack selection logic
  const packs = document.querySelectorAll('.pack');
  const sumPack = document.getElementById('sumPack');
  const sumPrice = document.getElementById('sumPrice');
  const sumTotal = document.getElementById('sumTotal');
  window.codCharge = 99;

  packs.forEach(pack => {
    pack.addEventListener('click', () => {
      packs.forEach(p => p.classList.remove('active'));
      pack.classList.add('active');
      const price = parseFloat(pack.dataset.price);
      sumPack.textContent = pack.dataset.name;
      sumPrice.textContent = '৳ ' + price.toFixed(2);
      sumTotal.textContent = '৳ ' + (price + window.codCharge).toFixed(2);
    });
  });

  // Scroll to billing form
  const btnOrderNow = document.getElementById('btn-order-now');
  if (btnOrderNow) {
    btnOrderNow.addEventListener('click', () => {
      const formEl = document.getElementById('billing-form');
      if (formEl) {
        formEl.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }

  // Submit Order via AJAX
  const btnConfirmOrder = document.getElementById('btn-confirm-order');
  if (btnConfirmOrder) {
    btnConfirmOrder.addEventListener('click', async () => {
      const name = document.getElementById('customer_name').value.trim();
      const address = document.getElementById('address').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const note = document.getElementById('note').value.trim();

      if (!name || !address || !phone) {
        alert('অনুগ্রহ করে সব তারকা চিহ্নিত (*) তথ্য পূরণ করুন।');
        return;
      }

      const activePack = document.querySelector('.pack.active');
      const packageName = activePack ? activePack.dataset.name : '৬ প্যাক';
      const productPrice = activePack ? parseFloat(activePack.dataset.price) : 354.00;
      const deliveryCharge = window.codCharge || 99;
      const totalPrice = productPrice + deliveryCharge;

      btnConfirmOrder.disabled = true;
      btnConfirmOrder.textContent = '⏳ প্রসেস হচ্ছে...';

      try {
        const response = await fetch('/order/submit', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            customer_name: name,
            address: address,
            phone: phone,
            note: note,
            package_name: packageName,
            product_price: productPrice,
            delivery_charge: deliveryCharge,
            total_price: totalPrice
          })
        });

        const data = await response.json();

        if (response.ok && data.success) {
          if (typeof fbq === 'function') {
            fbq('track', 'Purchase', {
              value: totalPrice,
              currency: 'BDT'
            });
          }
          // Show premium success overlay/card
          const formContainer = document.getElementById('form-container');
          formContainer.innerHTML = `
            <div style="text-align: center; padding: 2rem 1rem; color: #1c2b4a;">
              <span style="font-size: 4rem; display: block; margin-bottom: 1rem; color: var(--orange);">🎉</span>
              <h4 style="font-size: 1.25rem; font-weight: 700; color: var(--orange); margin-bottom: 0.5rem;">অর্ডার সফল হয়েছে!</h4>
              <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">
                আপনার অর্ডারটি সফলভাবে আমাদের সিস্টেমে যুক্ত হয়েছে। <br>
                অর্ডার আইডি: <strong style="color: var(--text-dark);">#${data.order_id}</strong>
              </p>
              <p style="font-size: 0.85rem; color: var(--text-muted);">আমাদের প্রতিনিধি শীঘ্রই আপনার মোবাইল নম্বরে কল করে অর্ডারটি কনফার্ম করবেন।</p>
            </div>
          `;
        } else {
          throw new Error(data.message || 'অর্ডার সাবমিট করতে সমস্যা হয়েছে।');
        }
      } catch (err) {
        alert(err.message || 'দুঃখিত, কোনো একটি ত্রুটি ঘটেছে। আবার চেষ্টা করুন।');
        btnConfirmOrder.disabled = false;
        btnConfirmOrder.textContent = 'অর্ডার কনফার্ম করুন';
      }
    });
  }
</script>
</body>
</html>

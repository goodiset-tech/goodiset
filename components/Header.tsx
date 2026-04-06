"use client";

import { useState } from "react";
import Link from "next/link";
import Image from "next/image";

export default function Header() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const categories = [
    { name: "Pick & Mix", slug: "pick-mix", image: "/img/category/pick-mix.webp" },
    { name: "Pre-Mixed Bags", slug: "pre-mixed", image: "/img/category/premixed.webp" },
    { name: "Chocolates", slug: "chocolates", image: "/img/category/chocolates.webp" },
    { name: "Gift Boxes", slug: "gift-boxes", image: "/img/category/giftbox.webp" },
  ];

  return (
    <>
      {/* Announcement Bar */}
      <div className="announcement-bar">
        <div className="container">
          <div className="ann-text">
            <p>Free delivery on orders over AED 100 | Use code SWEET10 for 10% off</p>
          </div>
        </div>
      </div>

      {/* Main Header */}
      <div className="main_header">
        <div className="container">
          <nav className="navbar_container">
            <div className="logo-wrapper">
              <Link href="/" title="Goodiset Logo">
                <Image
                  src="/front/assets/images/logo.png"
                  alt="Goodiset Swedish Candy"
                  width={165}
                  height={72}
                  className="logo"
                  priority
                />
              </Link>
              
              <ul className="nav-ul">
                <li>
                  <div className="mega-dropdown">
                    <button className="mega-dropdown-toggle nav_item" title="Shop Menu">
                      <span>Shop</span>
                      <i className="fa-solid fa-angle-down mega_menu_arrow"></i>
                    </button>
                    <div className="mega-dropdown-menu">
                      <div className="mega_dropdown_menu_inner">
                        <div className="menu-left">
                          <ul>
                            <li className="category category_item">
                              <Link href="/shop">All Products</Link>
                            </li>
                            <li className="category category_item">
                              <Link href="/category/pick-mix">Pick & Mix</Link>
                            </li>
                            <li className="category category_item">
                              <Link href="/category/pre-mixed">Pre-Mixed Bags</Link>
                            </li>
                            <li className="category category_item">
                              <Link href="/category/chocolates">Chocolates</Link>
                            </li>
                            <li className="category category_item">
                              <Link href="/category/gift-boxes">Gift Boxes</Link>
                            </li>
                          </ul>
                        </div>
                        <div className="menu-right zero_category active">
                          <div className="row">
                            {categories.map((cat) => (
                              <div key={cat.slug} className="col-md-3">
                                <div className="category_wrapper">
                                  <Link href={`/category/${cat.slug}`} style={{ display: 'block' }}>
                                    <Image
                                      src={cat.image}
                                      alt={cat.name}
                                      width={200}
                                      height={200}
                                      style={{ width: '100%', height: '200px', objectFit: 'cover' }}
                                    />
                                    <p>{cat.name}</p>
                                  </Link>
                                </div>
                              </div>
                            ))}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <Link href="/about" className="nav_item">About Us</Link>
                </li>
                <li>
                  <Link href="/blogs" className="nav_item">Blog</Link>
                </li>
                <li>
                  <Link href="/contact" className="nav_item">Contact</Link>
                </li>
              </ul>
            </div>

            <div className="nav-actions">
              <button className="nav-icon" aria-label="Search">
                <i className="fa-solid fa-magnifying-glass"></i>
              </button>
              <Link href="/login" className="nav-icon" aria-label="Account">
                <i className="fa-regular fa-user"></i>
              </Link>
              <Link href="/cart" className="nav-icon cart-icon" aria-label="Cart">
                <i className="fa-solid fa-bag-shopping"></i>
                <span className="cart-count">0</span>
              </Link>
              <button
                className="mobile-menu-btn"
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                aria-label="Menu"
              >
                <i className={`fa-solid ${mobileMenuOpen ? 'fa-xmark' : 'fa-bars'}`}></i>
              </button>
            </div>
          </nav>
        </div>
      </div>

      {/* Mobile Menu */}
      {mobileMenuOpen && (
        <div className="mobile-menu">
          <div className="container">
            <Link href="/shop" className="mobile-menu-item">Shop All</Link>
            {categories.map((cat) => (
              <Link
                key={cat.slug}
                href={`/category/${cat.slug}`}
                className="mobile-menu-item sub"
              >
                {cat.name}
              </Link>
            ))}
            <Link href="/about" className="mobile-menu-item">About Us</Link>
            <Link href="/blogs" className="mobile-menu-item">Blog</Link>
            <Link href="/contact" className="mobile-menu-item">Contact</Link>
          </div>
        </div>
      )}

      <style jsx>{`
        .announcement-bar {
          background: #e92827;
          color: #fff;
          text-align: center;
          padding: 10px 0;
          font-size: 14px;
        }
        .ann-text p {
          margin: 0;
        }
        .main_header {
          background: #fff;
          position: sticky;
          top: 0;
          z-index: 100;
          box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .navbar_container {
          display: flex;
          align-items: center;
          justify-content: space-between;
          padding: 16px 0;
        }
        .logo-wrapper {
          display: flex;
          align-items: center;
          gap: 40px;
        }
        .logo {
          height: 56px;
          width: auto;
        }
        .nav-ul {
          display: flex;
          align-items: center;
          gap: 32px;
          list-style: none;
          margin: 0;
          padding: 0;
        }
        .nav_item {
          font-family: "DM Sans", sans-serif;
          font-size: 16px;
          font-weight: 500;
          color: #303030;
          background: none;
          border: none;
          cursor: pointer;
          display: flex;
          align-items: center;
          gap: 6px;
        }
        .nav_item:hover {
          color: #e92827;
        }
        .nav-actions {
          display: flex;
          align-items: center;
          gap: 16px;
        }
        .nav-icon {
          width: 40px;
          height: 40px;
          display: flex;
          align-items: center;
          justify-content: center;
          color: #303030;
          font-size: 18px;
          background: none;
          border: none;
          cursor: pointer;
          border-radius: 50%;
          transition: all 0.2s;
        }
        .nav-icon:hover {
          background: #fef2f2;
          color: #e92827;
        }
        .cart-icon {
          position: relative;
        }
        .cart-count {
          position: absolute;
          top: 0;
          right: 0;
          background: #e92827;
          color: #fff;
          font-size: 11px;
          font-weight: 600;
          width: 18px;
          height: 18px;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
        }
        .mobile-menu-btn {
          display: none;
        }
        .mobile-menu {
          display: none;
          background: #fff;
          border-top: 1px solid #eee;
          padding: 16px 0;
        }
        .mobile-menu-item {
          display: block;
          padding: 12px 0;
          color: #303030;
          font-weight: 500;
        }
        .mobile-menu-item.sub {
          padding-left: 16px;
          font-weight: 400;
          color: #6e6e6e;
        }
        @media (max-width: 992px) {
          .nav-ul {
            display: none;
          }
          .mobile-menu-btn {
            display: flex;
          }
          .mobile-menu {
            display: block;
          }
        }
      `}</style>
    </>
  );
}

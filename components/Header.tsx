"use client";

import { useState } from "react";
import Link from "next/link";

export default function Header() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  return (
    <header>
      {/* Announcement Bar */}
      <div className="bg-[#e92827] text-white text-center py-2.5 text-sm">
        <p className="m-0">Same-day delivery in Dubai for orders placed before 8:00 pm and next-day across the UAE.</p>
      </div>

      {/* Main Header */}
      <div className="bg-white sticky top-0 z-50 shadow-sm">
        <div className="max-w-[1290px] mx-auto px-4">
          <nav className="flex items-center justify-between py-4">
            {/* Logo */}
            <Link href="/" className="flex items-center">
              <span className="text-3xl font-bold" style={{ fontFamily: 'Caprasimo, cursive', color: '#e92827' }}>
                Goodiset
              </span>
            </Link>

            {/* Desktop Nav */}
            <ul className="hidden lg:flex items-center gap-8 list-none m-0 p-0">
              <li>
                <Link href="/shop" className="text-base font-medium text-gray-800 hover:text-[#e92827] transition-colors">
                  Shop
                </Link>
              </li>
              <li>
                <Link href="/category/confectionary" className="text-base font-medium text-gray-800 hover:text-[#e92827] transition-colors">
                  Confectionary
                </Link>
              </li>
              <li>
                <Link href="/category/gift-boxes" className="text-base font-medium text-gray-800 hover:text-[#e92827] transition-colors">
                  Gift Boxes
                </Link>
              </li>
              <li>
                <Link href="/category/chocolate" className="text-base font-medium text-gray-800 hover:text-[#e92827] transition-colors">
                  Chocolate
                </Link>
              </li>
              <li>
                <Link href="/category/candy-mixes" className="text-base font-medium text-gray-800 hover:text-[#e92827] transition-colors">
                  Candy Mixes
                </Link>
              </li>
              <li>
                <Link href="/category/bubs" className="text-base font-medium text-gray-800 hover:text-[#e92827] transition-colors">
                  Bubs
                </Link>
              </li>
              <li>
                <Link href="/category/pick-mix" className="text-base font-medium text-gray-800 hover:text-[#e92827] transition-colors">
                  Pick & Mix
                </Link>
              </li>
            </ul>

            {/* Actions */}
            <div className="flex items-center gap-3">
              <button className="w-10 h-10 flex items-center justify-center text-gray-800 hover:text-[#e92827] hover:bg-red-50 rounded-full transition-all" aria-label="Search">
                <i className="fa-solid fa-magnifying-glass text-lg"></i>
              </button>
              <Link href="/login" className="w-10 h-10 flex items-center justify-center text-gray-800 hover:text-[#e92827] hover:bg-red-50 rounded-full transition-all" aria-label="Account">
                <i className="fa-regular fa-user text-lg"></i>
              </Link>
              <Link href="/cart" className="relative w-10 h-10 flex items-center justify-center text-gray-800 hover:text-[#e92827] hover:bg-red-50 rounded-full transition-all" aria-label="Cart">
                <i className="fa-solid fa-bag-shopping text-lg"></i>
                <span className="absolute top-0 right-0 bg-[#e92827] text-white text-[11px] font-semibold w-[18px] h-[18px] rounded-full flex items-center justify-center">0</span>
              </Link>
              <button
                className="lg:hidden w-10 h-10 flex items-center justify-center text-gray-800"
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                aria-label="Menu"
              >
                <i className={`fa-solid ${mobileMenuOpen ? 'fa-xmark' : 'fa-bars'} text-xl`}></i>
              </button>
            </div>
          </nav>
        </div>

        {/* Mobile Menu */}
        {mobileMenuOpen && (
          <div className="lg:hidden bg-white border-t border-gray-100 py-4">
            <div className="max-w-[1290px] mx-auto px-4 flex flex-col gap-2">
              <Link href="/shop" className="py-3 text-gray-800 font-medium">Shop</Link>
              <Link href="/category/confectionary" className="py-3 text-gray-600 pl-4">Confectionary</Link>
              <Link href="/category/gift-boxes" className="py-3 text-gray-600 pl-4">Gift Boxes</Link>
              <Link href="/category/chocolate" className="py-3 text-gray-600 pl-4">Chocolate</Link>
              <Link href="/category/candy-mixes" className="py-3 text-gray-600 pl-4">Candy Mixes</Link>
              <Link href="/category/bubs" className="py-3 text-gray-600 pl-4">Bubs</Link>
              <Link href="/category/pick-mix" className="py-3 text-gray-600 pl-4">Pick & Mix</Link>
              <Link href="/login" className="py-3 text-gray-800 font-medium border-t border-gray-100 mt-2 pt-4">Login</Link>
            </div>
          </div>
        )}
      </div>
    </header>
  );
}

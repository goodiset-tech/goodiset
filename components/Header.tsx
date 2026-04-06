"use client";

import { useState } from "react";
import Link from "next/link";
import Image from "next/image";
import { Menu, X, ShoppingBag, Search, User, ChevronDown } from "lucide-react";

export default function Header() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [shopMenuOpen, setShopMenuOpen] = useState(false);

  const categories = [
    { name: "Pick & Mix", slug: "pick-mix", color: "#FF6B6B" },
    { name: "Pre-Mixed Bags", slug: "pre-mixed", color: "#4ECDC4" },
    { name: "Chocolates", slug: "chocolates", color: "#95E1D3" },
    { name: "Gift Boxes", slug: "gift-boxes", color: "#F38181" },
  ];

  return (
    <>
      {/* Announcement Bar */}
      <div className="bg-[#e63946] text-white text-center py-2 px-4 text-sm">
        <p>Free delivery on orders over AED 100 | Use code SWEET10 for 10% off</p>
      </div>

      {/* Main Header */}
      <header className="bg-white shadow-sm sticky top-0 z-50">
        <div className="container">
          <nav className="flex items-center justify-between py-4">
            {/* Logo */}
            <Link href="/" className="flex-shrink-0">
              <Image
                src="/front/assets/images/logo.png"
                alt="Goodiset Swedish Candy"
                width={165}
                height={72}
                className="h-14 w-auto"
                priority
              />
            </Link>

            {/* Desktop Navigation */}
            <div className="hidden lg:flex items-center gap-8">
              <div
                className="relative"
                onMouseEnter={() => setShopMenuOpen(true)}
                onMouseLeave={() => setShopMenuOpen(false)}
              >
                <button className="flex items-center gap-1 text-gray-700 hover:text-[#e63946] font-medium transition-colors">
                  Shop <ChevronDown className="w-4 h-4" />
                </button>

                {/* Mega Menu */}
                {shopMenuOpen && (
                  <div className="absolute top-full left-0 w-[600px] bg-white shadow-xl rounded-lg p-6 mt-2">
                    <div className="grid grid-cols-2 gap-6">
                      <div>
                        <h3 className="font-semibold text-gray-900 mb-3">Categories</h3>
                        <ul className="space-y-2">
                          <li>
                            <Link href="/shop" className="text-gray-600 hover:text-[#e63946] transition-colors">
                              All Products
                            </Link>
                          </li>
                          {categories.map((cat) => (
                            <li key={cat.slug}>
                              <Link
                                href={`/category/${cat.slug}`}
                                className="text-gray-600 hover:text-[#e63946] transition-colors flex items-center gap-2"
                              >
                                <span
                                  className="w-3 h-3 rounded-full"
                                  style={{ backgroundColor: cat.color }}
                                />
                                {cat.name}
                              </Link>
                            </li>
                          ))}
                        </ul>
                      </div>
                      <div>
                        <h3 className="font-semibold text-gray-900 mb-3">Popular</h3>
                        <ul className="space-y-2">
                          <li>
                            <Link href="/shop?filter=bestsellers" className="text-gray-600 hover:text-[#e63946] transition-colors">
                              Best Sellers
                            </Link>
                          </li>
                          <li>
                            <Link href="/shop?filter=new" className="text-gray-600 hover:text-[#e63946] transition-colors">
                              New Arrivals
                            </Link>
                          </li>
                          <li>
                            <Link href="/shop?filter=sale" className="text-gray-600 hover:text-[#e63946] transition-colors">
                              On Sale
                            </Link>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                )}
              </div>

              <Link href="/about" className="text-gray-700 hover:text-[#e63946] font-medium transition-colors">
                About Us
              </Link>
              <Link href="/blogs" className="text-gray-700 hover:text-[#e63946] font-medium transition-colors">
                Blog
              </Link>
              <Link href="/contact" className="text-gray-700 hover:text-[#e63946] font-medium transition-colors">
                Contact
              </Link>
            </div>

            {/* Right Side Actions */}
            <div className="flex items-center gap-4">
              <button className="p-2 text-gray-700 hover:text-[#e63946] transition-colors" aria-label="Search">
                <Search className="w-5 h-5" />
              </button>
              <Link href="/login" className="p-2 text-gray-700 hover:text-[#e63946] transition-colors" aria-label="Account">
                <User className="w-5 h-5" />
              </Link>
              <Link href="/cart" className="p-2 text-gray-700 hover:text-[#e63946] transition-colors relative" aria-label="Cart">
                <ShoppingBag className="w-5 h-5" />
                <span className="absolute -top-1 -right-1 bg-[#e63946] text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                  0
                </span>
              </Link>

              {/* Mobile Menu Button */}
              <button
                className="lg:hidden p-2 text-gray-700"
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                aria-label="Menu"
              >
                {mobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
              </button>
            </div>
          </nav>
        </div>

        {/* Mobile Menu */}
        {mobileMenuOpen && (
          <div className="lg:hidden bg-white border-t">
            <div className="container py-4 space-y-4">
              <Link href="/shop" className="block text-gray-700 hover:text-[#e63946] font-medium py-2">
                Shop All
              </Link>
              {categories.map((cat) => (
                <Link
                  key={cat.slug}
                  href={`/category/${cat.slug}`}
                  className="block text-gray-600 hover:text-[#e63946] py-2 pl-4"
                >
                  {cat.name}
                </Link>
              ))}
              <Link href="/about" className="block text-gray-700 hover:text-[#e63946] font-medium py-2">
                About Us
              </Link>
              <Link href="/blogs" className="block text-gray-700 hover:text-[#e63946] font-medium py-2">
                Blog
              </Link>
              <Link href="/contact" className="block text-gray-700 hover:text-[#e63946] font-medium py-2">
                Contact
              </Link>
            </div>
          </div>
        )}
      </header>
    </>
  );
}
